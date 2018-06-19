<?php

namespace App\Repositories;

use App\Models\LeanTool;
use App\Repositories\Contracts\QuizRepositoryInterface;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Types\Mixed_;

class QuizRepository extends BaseRepository implements QuizRepositoryInterface
{

    public function model()
    {
        return new LeanTool();
    }

    public function getAllQuiz($user): Collection
    {
        $result = $this->model()->with(['quizResult' => function ($query) use ($user) {
            $query->orderby('created_at', 'desc')->where('user_id', $user)->get();
        }])->get();
        $data = $result->map(function ($item) {
            $score = count($item['quizResult']) > 0 ? $item['quizResult'][0]['score'] : 'Pending';
            return [
                'tool_id' => $item['id'],
                'name' => $item['name'],
                'score' => $score
            ];
        });
        return $data;
    }

    public function getQuizItems($tool)
    {
        $result = $this->model()->find($tool);
        return $result->quiz;
    }

    /*Add*/

    /*update*/
}