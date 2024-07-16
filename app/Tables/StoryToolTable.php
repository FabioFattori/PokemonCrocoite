<?php

namespace App\Tables;
use App\Models\StoryTool;
use App\Tables\Class\Column;
use App\Tables\Class\Types;

class StoryToolMode{
    public const all = 0;
    public const ofUser = 1;
}

class StoryToolTable extends Table{
    private int $mode;
    private int $userId;

    private array $dependencies = [];
    public function getDependencies(): array{
        return $this->dependencies;
    }

    public function getQuery(): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder{
        if($this->mode == StoryToolMode::all){
            return StoryTool::query();
        }else {
            $q = StoryTool::query();
            $q = $q->leftJoin("story_tool_user","story_tool_user.story_tool_id","=","story_tool_user.id")->leftJoin("users","users.id","=","story_tool_user.user_id");
            return $q; 
        }
    }

    public function __construct($mode = StoryToolMode::all, $userId = -1){
        $this->setId(9231);
        $this->mode = $mode;
        $this->userId = $userId;
        parent::__construct();
        if($mode == StoryToolMode::ofUser){
            $this->setColumns([
                "id" => Column::Hidden("id","story_tools.id","id",types:Types::INTEGER,isOriginal:true),
                "name" => Column::Visible("name","story_tools.name","Nome",isOriginal:true),
                "description" => Column::Visible("description","story_tools.description","Descrizione",isOriginal:true),
                "quantity" => Column::Visible("quantity","story_tool_user.quantity","Quantità",isOriginal:false),
            ]);
        }else{
            $this->setColumns([
                "id" => Column::Hidden("id","story_tools.id","id",types:Types::INTEGER,isOriginal:true),
                "name" => Column::Visible("name","story_tools.name","Nome",isOriginal:true),
                "description" => Column::Visible("description","story_tools.description","Descrizione",isOriginal:true),
                
            ]);
        }
    }
}