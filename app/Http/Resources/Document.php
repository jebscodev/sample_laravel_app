<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Client;
use App\Http\Resources\Client as ClientResource;
use Carbon\Carbon;

class Document extends JsonResource
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
            'cust_prof' => $this->cust_prof,
            'cust_reg' => $this->cust_reg,
            'tin_dec' => $this->tin_dec,
            'ids' => $this->ids,
            'prof_acq' => $this->prof_acq,
            'res_agnt' => $this->res_agnt,
            'prov_rcpt' => $this->prov_rcpt,
            'term_sht' => $this->term_sht,
            'birth_cert' => $this->birth_cert,
            'marriage_cert' => $this->marriage_cert,
            'cenomar' => $this->cenomar,
            'proof_of_income' => $this->proof_of_income,
            'proof_of_billing' => $this->proof_of_billing,
            'pdc' => $this->pdc,
            'requirements_status' => $this->requirements_status,
            'requirements_status_text' => $requirement_status_text,
            'class' => $class,
            'cell_error_class' => $cell_error_class,
            'status' => $this->status,
            'status_text' => $this->status ? 'Active' : 'Inactive',
            'date_completed' => Carbon::parse($this->date_completed)->toDateString(),
            'remarks' => $this->remarks,
            'count_submitted' => $this->countSubmitted(),
            'client' => $this->whenLoaded('client')
        ];
    }
}
