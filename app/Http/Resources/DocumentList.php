<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class DocumentList extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        switch($this->requirements_status){
            case '0':
                $requirement_status_text = 'Incomplete';
                $class = "inactive_class";
                $cell_error_class = '';
                break;
            case '1':
                $requirement_status_text = 'Complete';
                $class = "active_class";
                $cell_error_class = '';
                break;
            case '2':
                $requirement_status_text = 'Override';
                $class = "error_class";
                $cell_error_class = 'cell_error_class';
                break;
            default:
                $requirement_status_text = 'Incomplete';
                $class = "inactive_class";
                break;
        }

        return [
            'id' => $this->id,
            'requirements_status_text' => $requirement_status_text,
            'class' => $class,
            'cell_error_class' => $cell_error_class,
            'date_completed' => Carbon::parse($this->date_completed)->toDateString(),
            'count_submitted' => $this->countSubmitted(),
            'client' => $this->whenLoaded('client')
        ];
    }
}
