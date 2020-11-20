<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\User as UserResource;
use App\Role;
use App\Http\Resources\Role as RoleResource;
use App\Broker;
use App\Http\Resources\Broker as BrokerResource;
use App\Prospect;
use App\Http\Resources\Prospect as ProspectResource;
use App\UnitType;
use App\Http\Resources\UnitType as UnitTypeResource;
use App\Project;
use App\Http\Resources\Project as ProjectResource;
use App\Unit;
use App\Http\Resources\UnitList as UnitListResource;
use App\Client;
use App\Http\Resources\Client as ClientResource;
use App\Document;
use App\Http\Resources\Document as DocumentResource;
use App\Equity;
use App\Http\Resources\Equity as EquityResource;
use App\CtsFile;
use App\Http\Resources\CtsFile as CtsFileResource;
use App\Ewt;
use App\Http\Resources\Ewt as EwtResource;
use App\LoanTakeout;
use App\Http\Resources\LoanTakeout as LoanTakeoutResource;


class SearchController extends Controller
{

    /**
     * Display search result.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function result(Request $request)
    {
        if ($request->has('unit') && $request->has('project')) { 
            $project_id = ($request->query('project'));
            $needle = strtolower(urldecode($request->query('unit')));
            $units = Unit::with([
                    'client:unit_id,id,client_name'
                ]);

            switch ($needle) {
                case 'active':
                case 'inactive':
                    $status = $needle === 'active' ? 1 : 0;
                    $result = $units->where('project_id', $project_id)
                        ->where('status', $status)
                        ->paginate();
                    break;

                case 'sold':
                case 'unsold':
                    $sale_status = $needle === 'sold' ? 1 : 0;
                    $result = $units->where('project_id', $project_id)
                        ->where('sale_status', $sale_status)
                        ->paginate();
                    break;
                
                default:
                    $result = $units->where('project_id', $project_id)
                        ->where(function ($query) use ($needle) {
                            $query->where('unit_no', 'LIKE', '%'.$needle.'%')
                                ->orWhere('area', 'LIKE', '%'.$needle.'%')
                                ->orWhere('tcp', 'LIKE', '%'.$needle.'%')
                                ->orWhereHas('project', function ($query2) use ($needle) {
                                    $query2->where('name', 'LIKE', '%'.$needle.'%');
                                })
                                ->orWhereHas('client', function ($query2) use ($needle) {
                                    $query2->where('client_name', 'LIKE', '%'.$needle.'%');
                                });
                        })
                        ->paginate();
                    break;
            }

            return UnitListResource::collection($result);
        }

        if ($request->has('user')) {
            $needle = strtolower(urldecode($request->query('user')));
            $users = new User();

            switch ($needle) {
                case 'active':
                case 'inactive':
                    $status = $needle === 'active' ? 1 : 0;
                    $result = $users->where('status', $status)->paginate();
                    break;
                
                default:
                    $result = $users->where('first_name', 'LIKE', '%'.$needle.'%')
                        ->orWhere('last_name', 'LIKE', '%'.$needle.'%')
                        ->orWhere('updated_by', '=', function ($query) use ($needle) {
                            $query->select('id')
                            ->from('users')
                            ->where('first_name', 'LIKE', '%'.$needle.'%')
                            ->orWhere('last_name', 'LIKE', '%'.$needle.'%');
                        })
                        ->orWhereHas('role', function ($query) use ($needle) {
                            $query->where('name', 'LIKE', '%'.$needle.'%');
                        })
                        ->paginate();
                    break;
            }

            return UserResource::collection($result);
        }
        
        if ($request->has('role')) {
            $needle = strtolower(urldecode($request->query('role')));
            $roles = new Role();

            switch ($needle) {
                case 'active':
                case 'inactive':
                    $status = $needle === 'active' ? 1 : 0;
                    $result = $roles->where('status', $status)->paginate();
                    break;
                
                default:
                    $result = $roles->where('name', 'LIKE', '%'.$needle.'%')
                        ->orWhere('description', 'LIKE', '%'.$needle.'%')
                        ->paginate();
                    break;
            }
            
            return RoleResource::collection($result);
        }

        if ($request->has('broker')) {
            $needle = strtolower(urldecode($request->query('broker')));
            $brokers = new Broker();

            switch ($needle) {
                case 'active':
                case 'inactive':
                    $status = $needle === 'active' ? 1 : 0;
                    $result = $brokers->where('status', $status)->paginate();
                    break;
                
                default:
                    $result = $brokers->where('first_name', 'LIKE', '%'.$needle.'%')
                        ->orWhere('last_name', 'LIKE', '%'.$needle.'%')
                        ->orWhere('email_address', 'LIKE', '%'.$needle.'%')
                        ->orWhere('address', 'LIKE', '%'.$needle.'%')
                        ->orWhere('contact_no', 'LIKE', '%'.$needle.'%')
                        ->paginate();
                    break;
            }

            return BrokerResource::collection($result);
        }

        if ($request->has('prospect')) {
            $needle = strtolower(urldecode($request->query('prospect')));
            $prospects = new Prospect();

            switch ($needle) {
                case 'active':
                case 'inactive':
                    $status = $needle === 'active' ? 1 : 0;
                    $result = $prospects->where('status', $status)->paginate();
                    break;
                
                default:
                    $result = $prospects->where('first_name', 'LIKE', '%'.$needle.'%')
                        ->orWhere('last_name', 'LIKE', '%'.$needle.'%')
                        ->orWhere('email_address', 'LIKE', '%'.$needle.'%')
                        ->orWhere('address', 'LIKE', '%'.$needle.'%')
                        ->orWhere('contact_no', 'LIKE', '%'.$needle.'%')
                        ->paginate();
                    break;
            }

            return ProspectResource::collection($result);
        }

        if ($request->has('unittype')) {
            $needle = strtolower(urldecode($request->query('unittype')));
            $unit_types = new UnitType();

            switch ($needle) {
                case 'active':
                case 'inactive':
                    $status = $needle === 'active' ? 1 : 0;
                    $result = $unit_types->where('status', $status)->paginate();
                    break;
                
                default:
                    $result = $unit_types->where('name', 'LIKE', '%'.$needle.'%')
                        ->orWhere('description', 'LIKE', '%'.$needle.'%')
                        ->paginate();
                    break;
            }

            return UnitTypeResource::collection($result);
        }

        if ($request->has('project')) {
            $needle = strtolower(urldecode($request->query('project')));
            $projects = new Project();

            switch ($needle) {
                case 'active':
                case 'inactive':
                    $status = $needle === 'active' ? 1 : 0;
                    $result = $projects->where('status', $status)->paginate();
                    break;
                
                default:
                    $result = $projects->where('name', 'LIKE', '%'.$needle.'%')
                        ->orWhere('location', 'LIKE', '%'.$needle.'%')
                        ->paginate();
                    break;
            }

            return ProjectResource::collection($result);
        }

        if ($request->has('reservation')) {
            $needle = strtolower(urldecode($request->query('reservation')));

            $clients = Client::with([
                'project:id,name',
                'unit:id,unit_no'
            ]);

            switch ($needle) {
                case 'active':
                case 'inactive':
                    $status = $needle === 'active' ? 1 : 0;
                    $result = $clients->where('status', $status)->paginate();
                    break;

                default:
                    $result = $clients->where('client_name', 'LIKE', '%'.$needle.'%')->paginate();
                    break;
            }

            return ClientResource::collection($result);
        }

        if ($request->has('document')) {
            $needle = strtolower(urldecode($request->query('document')));

            $documents = Document::with([
                'client:id,client_name,project_id,unit_id',
                'client.project:id,name',
                'client.unit:id,unit_no'
            ]);

            switch ($needle) {
                case 'active':
                case 'inactive':
                    $status = $needle === 'active' ? 1 : 0;
                    $result = $documents->where('status', $status)->paginate();
                    break;

                case 'complete':
                case 'incomplete':
                    $status = $needle === 'complete' ? 1 : 0;
                    $result = $documents->where('requirements_status', $status)->paginate();
                    break;
                    
                default:
                    $result = $documents->whereHas('client', function ($query) use ($needle) {
                        $query->where('client_name', 'LIKE', '%'.$needle.'%');
                    })
                    ->paginate();
                    break;
            }

            return DocumentResource::collection($result);
        }

        if ($request->has('equity')) {
            $needle = strtolower(urldecode($request->query('equity')));

            $equity = Equity::with([
                'client:id,client_name',
                'client.documents:id,client_id,requirements_status',
                'client.cts_file:id,client_id,cts_status'
            ]);

            $result = $equity->where('total_equity', 'LIKE', '%'.$needle.'%')                
                ->orWhere('total_equity_paid', 'LIKE', '%'.$needle.'%')
                ->orWhere('total_penalties', 'LIKE', '%'.$needle.'%')
                ->orWhere('total_penalty_paid', 'LIKE', '%'.$needle.'%')
                ->orWhere('remaining_balance', 'LIKE', '%'.$needle.'%')
                ->orWhere('equity_paid_pctg', 'LIKE', '%'.$needle.'%')
                ->orWhere('letter_of_notice_status', 'LIKE', '%'.$needle.'%')
                ->orWhereHas('client', function ($query) use ($needle) {
                    $query->where('client_name', 'LIKE', '%'.$needle.'%')
                        ->orWhereHas('documents', function ($query2) use ($needle) {
                            $query2->where('requirements_status', 'LIKE', '%'.$needle.'%');
                        })
                        ->orWhereHas('cts_file', function ($query2) use ($needle) {
                            $query2->where('cts_status', 'LIKE', '%'.$needle.'%');
                        });
                })
                ->paginate();

            return EquityResource::collection($result);
        }

        if ($request->has('cts')) {
            $needle = strtolower(urldecode($request->query('cts')));

            $cts = CtsFile::with([
                'client:id,client_name'
            ]);

            $result = $cts->where('date_printed', 'LIKE', '%'.$needle.'%')
                ->orWhere('date_signed', 'LIKE', '%'.$needle.'%')
                ->orWhere('date_notarized', 'LIKE', '%'.$needle.'%')
                ->orWhere('cts_status', 'LIKE', '%'.$needle.'%')
                ->orWhere('total_days', 'LIKE', '%'.$needle.'%')
                ->orWhere('kra', 'LIKE', '%'.$needle.'%')
                ->orWhereHas('client', function ($query) use ($needle) {
                    $query->where('client_name', 'LIKE', '%'.$needle.'%');
                })
                ->paginate();

            return CtsFileResource::collection($result);
        }

        if ($request->has('ewt')) {
            $needle = strtolower(urldecode($request->query('ewt')));

            $ewt = Ewt::with([
                'client:id,client_name'
            ]);

            $result = $ewt->where('ewt_amount', 'LIKE', '%'.$needle.'%')
                ->orWhere('rcp_date', 'LIKE', '%'.$needle.'%')
                ->orWhere('est_release_date', 'LIKE', '%'.$needle.'%')
                ->orWhere('actual_release_date', 'LIKE', '%'.$needle.'%')
                ->orWhere('date_paid', 'LIKE', '%'.$needle.'%')
                ->orWhere('total_days', 'LIKE', '%'.$needle.'%')
                ->orWhere('kra', 'LIKE', '%'.$needle.'%')
                ->orWhereHas('client', function ($query) use ($needle) {
                    $query->where('client_name', 'LIKE', '%'.$needle.'%');
                })
                ->paginate();

            return EwtResource::collection($result);
        }

        if ($request->has('loantakeout')) {
            $needle = strtolower(urldecode($request->query('loantakeout')));

            $loan = LoanTakeout::with([
                'client'
            ]);

            $result = $loan->where('financing_scheme', 'LIKE', '%'.$needle.'%')
                ->orWhere('loan_status', 'LIKE', '%'.$needle.'%')
                ->orWhere('loan_amount', 'LIKE', '%'.$needle.'%')
                ->orWhere('tcp', 'LIKE', '%'.$needle.'%')
                ->orWhere('variance', 'LIKE', '%'.$needle.'%')
                ->orWhere('status', 'LIKE', '%'.$needle.'%')
                ->orWhere('total_days', 'LIKE', '%'.$needle.'%')
                ->orWhere('kra', 'LIKE', '%'.$needle.'%')
                ->orWhereHas('client', function ($query) use ($needle) {
                    $query->where('client_name', 'LIKE', '%'.$needle.'%')
                        ->orWhereHas('unit', function ($query2) use ($needle) {
                            $query2->where('unit_no', 'LIKE', '%'.$needle.'%');
                        });
                })
                ->paginate();

            return LoanTakeoutResource::collection($result);
        }
    }
}