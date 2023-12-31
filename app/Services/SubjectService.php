<?php

namespace App\Services;

use Exception;
use App\Models\Subject;
use App\DTO\Subject\CreateSubjectDto;
use App\DTO\Subject\UpdateSubjectDto;
use App\Exceptions\UknownException;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ItemNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use App\Exceptions\InvalidDataGivenException;

class SubjectService extends AbstractService
{

    /**
     * @throws Exception
     */
    public function create(CreateSubjectDto $data): Subject
    {

        $name = $data->name;
        $level_id = $data->level_id;

        $subjectExists = Subject::where("name", $name)->get();
        $subjectExists = Subject::where("level_id", $level_id)->exists();
        
        if ($subjectExists) {
            throw new InvalidDataGivenException("The subject already exists");
        }

        try {
            $subject = Subject::create([
                "name" => $name,
                "level_id" => $level_id,
                
            ]);

            return $subject;
        } catch (Exception $th) {
            Log::error("Failed to create school ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }

    public function getsubject(int $id): ?Subject
    {
        $subject = Subject::find($id);
        if (is_null($subject)) {
            throw new ItemNotFoundException("Sorry, this subject cannot be found");
        }
        return $subject;
    }

    public function allsubjects()
    {
        $subjects = Subject::
                        join('levels','levels.id','=','subjects.level_id')
                        ->select('levels.name','subjects.name as subjName', 'subjects.id')
                        ->get();
        return $subjects;
    }

    public function updatesubject(UpdateSubjectDto $data, int $id): Subject
    {
        $subject = Subject::find($id);
        if (is_null($subject)) {
            throw new ItemNotFoundException("The subject does not exist");
        }

        $name = $data->name;
        $level_id = $data->level_id;

        try {
            $subject->update([
                "name" => $name,
                "level_id" => $level_id,
            ]);

            return $subject;
        } catch (Exception $th) {

            Log::error("Failed to update subject ", [
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
        $subject = Subject::find($id);
        if (is_null($subject)) {
            throw new ItemNotFoundException("The subject does not exist");
        }
        return $subject->delete();
    }
}