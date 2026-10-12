<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Book;
use Illuminate\Support\Facades\Http;

#[Signature('books:fetch-covers')]
#[Description('Fetch book covers from Google Books API and save to cover_url')]
class FetchBookCovers extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $books = Book::whereNull('cover_url')->whereNull('sampul')->get();
        $this->info("Ditemukan {$books->count()} buku tanpa sampul. Mencari di Google Books API...");

        $updatedCount = 0;

        foreach ($books as $book) {
            $query = "intitle:\"{$book->judul}\"";
            if ($book->pengarang) {
                $query .= "+inauthor:\"{$book->pengarang}\"";
            }

            $response = Http::withoutVerifying()->get("https://www.googleapis.com/books/v1/volumes", [
                'q' => $query,
                'maxResults' => 3,
            ]);

            if ($response->successful() && $response->json('totalItems') > 0) {
                $items = $response->json('items');
                $found = false;

                foreach ($items as $item) {
                    $volumeInfo = $item['volumeInfo'] ?? [];
                    $apiTitle = $volumeInfo['title'] ?? '';
                    
                    similar_text(strtolower($book->judul), strtolower($apiTitle), $similarity);
                    
                    if ($similarity >= 70 && isset($volumeInfo['imageLinks']['thumbnail'])) {
                        $thumbnailUrl = str_replace('http://', 'https://', $volumeInfo['imageLinks']['thumbnail']);
                        $thumbnailUrl = str_replace('&edge=curl', '', $thumbnailUrl);
                        
                        $book->cover_url = $thumbnailUrl;
                        $book->save();
                        
                        $this->info("Sampul diperbarui: {$book->judul}");
                        $updatedCount++;
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    $this->warn("Tidak ditemukan kemiripan yang pas untuk: {$book->judul}");
                }
            } else {
                $this->warn("Tidak ditemukan di API: {$book->judul}");
            }
            
            usleep(200000); 
        }

        $this->info("Selesai! Berhasil memperbarui {$updatedCount} sampul buku.");
    }
}
