<?php

namespace App\Traits;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

trait FilterUsers
{

    public function filterUsers($query, Request $request)
    {
        $country = ($request->get('country') !== null) ? $request->get('country') : null; //$request->get('country') ?? null;
        $age_from = ($request->get('age_from') !== null) ? $request->get('age_from') : null; //$request->get('age_from') ?? null;
        $age_to = ($request->get('age_to') !== null) ? $request->get('age_to') : null; //$request->get('age_to') ?? null;
        $gender = ($request->get('gender') !== null) ? $request->get('gender') : null; //$request->get('gender') ?? null; 
        $bloodType = ($request->get('blood_type') !== null) ? $request->get('blood_type') : null; //$request->get('blood_type') ?? null;
        $diseases = ($request->get('disease') !== null) ? $request->get('disease') : null; //$request->get('disease') ?? null;
        $accountType = ($request->get('type') !== null) ? $request->get('type') : null; //$request->get('type') ?? null;
        $to = Carbon::now();
        $from = Carbon::now();
        $query->when($country, function ($query) use ($country) {
            $query->where('country', $country);
        });

        if ($age_from && !$age_to) {
            $query->where('birth_date', '<=', $to->subYears($age_from));
        } elseif ($age_to && !$age_from) {
            $query->where('birth_date', '>=', $from->subYears($age_to));
        } elseif ($age_from && $age_to) {
            $query->whereBetween('birth_date', [$from->subYears($age_to), $to->subYears($age_from)]);
        }
        if ($bloodType) {
            $query->whereHas('metas', function ($query) use ($bloodType) {
                $query->where('value', $bloodType);
            });
        }
        if ($accountType) {
            $query->whereHas('subscription', function ($query) use ($accountType) {
                $query->where('type', $accountType);
            });
        }
        if ($diseases) {
            $diseaseString = User::diseaseString($diseases);
            \Log::info('Disease String : ' . $diseaseString);
            $query->whereHas('healthStatuses', function ($query) use ($diseaseString) {
                $query->where('diseases', $diseaseString);
            });
        }

        $query->when($gender, function ($query) use ($gender) {
            $query->where('gender', $gender);
        });

    }

}