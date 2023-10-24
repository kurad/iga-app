<?php
namespace App\Services;

use Exception;
use App\Models\Unit;
use App\Models\Topic;
use App\DTO\Topic\CreateTopicDto;
use App\DTO\Topic\UpdateTopicDto;
use App\Services\AbstractService;
use App\Exceptions\UknownException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\ItemNotFoundException;
use Illuminate\Database\Eloquent\Collection;

class TopicService extends AbstractService
{
    /**
     * @throws Exception
     */
    public function createTopic(CreateTopicDto $data): Topic
    {
        $topic_title = $data->topic_title;
        $unit_id = $data->unit_id;
        $instructional_objectives = $data->instructional_objectives;
        
        $unit = Unit::find($unit_id);
        if (is_null($unit)) {
            throw new ItemNotFoundException("The unit does not exist");
        }
        try {
            $topic = Topic::create([
                "topic_title" => $topic_title,
                "instructional_objectives" => $instructional_objectives,
                "unit_id" => $unit_id,
                "user_id" => Auth::user()->id
                
            ]);
            return $topic;
        } catch (Exception $th) {
            Log::error("Failed to add the lesson ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }
    public function getTopic(int $id): ?Topic
    {
        $topic = Topic::find($id);
        if (is_null($topic)) {
            throw new ItemNotFoundException("Sorry, Topic can not be found");
        }
        return $topic;
    }
    public function allTopics(): Collection
    {
        $topics = Topic::with('unit')->get();
        return $topics;
    }
    public function topicsPerUnit(int $unitId): Collection
    {
        $topics = Topic::where("unit_id", "=", $unitId)->get();
        return $topics;
    }
    // public function lessonsPerUser(): Collection
    // {
    //     $user = Auth::id();
    //     $lessons = Lesson::join('units', 'units.id', '=', 'lessons.unit_id')
    //         ->join('subjects', 'subjects.id', '=', 'units.subject_id')
    //         ->join('class_setups', 'class_setups.id', '=', 'subjects.class_id')
    //         ->where('class_setups.user_id', '=', $user)
    //         //->select('lessons.title','lessons.topic_area')
    //         ->get(['lessons.id', 'lessons.title', 'lessons.topic_area', 'units.title as unitName', 
    //         'lessons.date', 'lessons.instructional_objective', 'class_setups.name as className']);
    //     $lessons = Lesson::join('units','units.id','=','lessons.unit_id')
    //                     ->join('subjects','subjects.id','=','units.subject_id')
    //                     ->join('class_setups','class_setups.id','=','subjects.class_id')
    //                     ->where('class_setups.user_id','=', $user)
    //                     //->select('lessons.title','lessons.topic_area')
    //                     ->get(['lessons.id','lessons.title','lessons.topic_area','units.title as unitName','lessons.date','lessons.instructional_objective']);
                        
    //     return $lessons;
    // }
    public function updateTopic(UpdateTopicDto $data, int $id): Topic
    {
        $topic = Topic::find($id);
        if (is_null($topic)) {
            throw new ItemNotFoundException("The Topic does not exist");
        }
        $topic_title = $data->topic_title;
        $unit_id = $data->unit_id;
        $instructional_objectives = $data->instructional_objectives;
        try {
            $topic->update([
                "topic_title" => $topic_title,
                "instructional_objectives" => $instructional_objectives,
                "unit_id" => $unit_id,
                "user_id" => Auth::user()->id
            ]);
            return $topic;
        } catch (Exception $th) {
            Log::error("Failed to update topic ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }
    public function destroy(int $id): bool
    {
        $topic = Topic::find($id);
        if (is_null($topic)) {
            throw new ItemNotFoundException("The Topic does not exist");
        }
        return $topic->delete();
    }
    
}