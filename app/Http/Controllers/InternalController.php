<?php

namespace App\Http\Controllers;

use App\Models\Internal;
use App\Models\Discount;
use Illuminate\Http\Request;

class InternalController extends Controller
{
    public function index()
    {
        // Mengambil semua data diskon yang diurutkan berdasarkan 'id' secara ascending
        $internal = Internal::all();

        // Memeriksa apakah koleksi diskon kosong
        // if ($data['models']->isEmpty()) {
        //     return view('website.internal')->with('message', 'No Internal available.');
        // }

        // Mengirim data ke view
        return view('website.internal', compact('internal'));
    }

    public function create()
    {
        // return view('website.create');
    }

    public function show()
    {
        // Fetch all discount records
        $discounts = Discount::all();

        $totalDiscountFixSum = 0;

        $count = $discounts->count();

        // Iterate over each discount and calculate the custom fields
        foreach ($discounts as $discount) {

            $balanceHeroDiscount = (float) ($discount->balance_hero ?? 0);
            $fourBudgetPromotion = (float) ($discount->four_budget_promotion ?? 0);
            $totalBalanceIncentive = (float) ($discount->total_balance_incentive ?? 0);
            $adjusmentHero = (float) ($discount->adjusment_hero ?? 0);

            // Initialize additional fields with default values
            $discount->adjustment_incentive = 0;
            $discount->additional_discount = 0;
            $discount->other_discount = 0;
            $discount->return_allowance = 0.10;
            $discount->budget_promotion = 4;
            $discount->discount_promo_claim = 0;

            // Calculate discount promo claim
            if ($fourBudgetPromotion != 0) {
                $discount->discount_promo_claim = round(($balanceHeroDiscount * 0.005) / $fourBudgetPromotion, 2);
            } else {
                $discount->discount_promo_claim = 0;
            }

            // Calculate discount incentive
            if ($fourBudgetPromotion != 0) {
                $discount->adjustment_incentive = round(($totalBalanceIncentive / $fourBudgetPromotion) * 0.005, 2);
            } else {
                $discount->adjustment_incentive = 0;
            }

            // Calculate fixed discount incentive
            $discount->discount_incentive_fix = round($discount->discount_Incentive + $discount->adjustment_incentive, 2);

            // Calculate fixed discount promo
            $discount->discount_promo_fix = round($discount->discount_promo_claim + $adjusmentHero, 2);

            // Calculate total discount fix
            $discount->total_discount_fix = round(
                $discount->discount_incentive_fix +
                    $discount->discount_promo_fix +
                    $discount->return_allowance +
                    $discount->budget_promotion +
                    $discount->additional_discount +
                    $discount->other_discount,
                2
            );
            $totalDiscountFixSum += $discount->total_discount_fix;
        }
        $discountRate = $count > 0 ? round($totalDiscountFixSum / $count, 2) : 0;
        // Pass the discounts collection to the view
        return view('website.discount_internal', compact('discounts', 'discountRate'));
    }

    public function store(Request $request)
    {
        // // Validasi form
        // $request->validate([
        //     'forms.*.level' => 'required',
        //     'forms.*.title_name' => 'required',
        // ]);

        // // Simpan data dari form
        // foreach ($request->forms as $form) {
        //     Internal::create([
        //         'level' => $form['level'],
        //         'title_name' => $form['title_name'],
        //         // Tambahkan kolom lainnya sesuai kebutuhan
        //     ]);
        // 

        // // Redirect ke halaman terkait atau tampilkan pesan sukses
        // return redirect()->route('internal')->with('success', 'Forms submitted successfully.');
    }
    public function edit(Request $request, Internal $internal)
    {
        $data = Internal::get();
        return view('website.create', compact('data'));
    }

    public function update(Request $request, Internal $internal)
    {
        // dd($request->all());
        $request->validate([
            'forms.*.level' => 'required|unique:internals,level',
            'forms.*.title_name' => 'required'
        ]);
        // dd($request->forms);
        foreach ($request->forms as $form) {
            dd($form);
            $isInternalExist = Internal::where('level', $form['level'])->first();

            if ($isInternalExist) {
                $isInternalExist->update($request->only('level', 'title_name'));
            } else {
                Internal::create([
                    'level' => $form['level'],
                    'title_name' => $form['title_name']
                ]);
            }
        }

        return redirect()->route('internal')->with('success', 'Forms submitted successfully.');
    }
}
