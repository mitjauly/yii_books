<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * TopAuthors model - handles logic for TOP 10 authors report
 */
class TopAuthors extends Model
{
    /**
     * Get TOP 10 authors who published the most books, grouped by year
     *
     * @return array Array of years with their top 10 authors
     * Format: [
     *   2025 => [
     *     ['author_name' => 'Author Name', 'book_count' => 5],
     *     ...
     *   ],
     *   2024 => [...],
     * ]
     */
    public static function getTopAuthorsByYear()
    {
        $sql = "
            SELECT
                b.year,
                a.name AS author_name,
                COUNT(DISTINCT b.id) AS book_count
            FROM book b
            INNER JOIN book_author ba ON b.id = ba.book_id
            INNER JOIN author a ON ba.author_id = a.id
            WHERE b.year IS NOT NULL
            GROUP BY b.year, a.id, a.name
            ORDER BY b.year DESC, book_count DESC, a.name ASC
        ";

        $results = Yii::$app->db->createCommand($sql)->queryAll();

        // Group by year and limit to top 10 per year
        $grouped = [];
        foreach ($results as $row) {
            $year = $row['year'];
            if (!isset($grouped[$year])) {
                $grouped[$year] = [];
            }

            // Only keep top 10 per year
            if (count($grouped[$year]) < 10) {
                $grouped[$year][] = [
                    'author_name' => $row['author_name'],
                    'book_count' => $row['book_count'],
                ];
            }
        }

        return $grouped;
    }
}
