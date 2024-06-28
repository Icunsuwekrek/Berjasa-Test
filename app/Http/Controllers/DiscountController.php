<?php

namespace App\Http\Controllers;

use App\Exports\DiscountExport;
use App\Models\Discount;
use Illuminate\Http\Request;
use App\Imports\DiscountsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DiscountController extends Controller
{
  public function index()
  {
    $discounts = Discount::all();
    $discounts_graph = [];
    $discounts_label = [];
    $target_graph = [];
    $target_label= [];

    $totalDiscountFixSum = 0;
    $totalTargetFixSum = 0;
    $count = $discounts->count();

    // Iterate over each discount and calculate the custom fields
    foreach ($discounts as $discount) {

      $balanceHeroDiscount = (float) ($discount->balance_hero ?? 0);
      $fourBudgetPromotion = (float) ($discount->four_budget_promotion ?? 0);
      $totalBalanceIncentive = (float) ($discount->total_balance_incentive ?? 0);
      $adjusmentHero = (float) ($discount->adjusment_hero ?? 0);
      $targetJune = (float) ($discount->target_june ?? 0);

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
      array_push($discounts_graph, $discount->total_discount_fix);
      array_push($discounts_label, $discount->total_discount_fix);

      $totalDiscountFixSum += $discount->total_discount_fix;
    // Format the targetJune value
    $targetJuneFormatted = number_format($targetJune, 0, ',', '.');

      //calculate discount total
      array_push($target_graph, $discount->target_june);
      array_push($target_label, $discount->target_june);

      $totalTargetFixSum +=$discount->target_june;
      $totalTargetFixSumFormatted = number_format($totalTargetFixSum, 0, ',', '.');

    }
    // dd($totalTargetFixSum);
    $discountRate = $count > 0 ? round($totalDiscountFixSum / $count, 2) : 0;

    return view('website.discount', compact('discounts', 'discountRate', 'discounts_graph', 'discounts_label', 'totalTargetFixSumFormatted', 'target_graph', 'target_label'));
  }

  public function create()
  {
    //
  }
  public function export()
  {
    return Excel::download(new DiscountExport, 'discount.xlsx');
  }
  public function import(Request $request)
  {
    $file = $request->file('file');
    $filePath = $file->store('excel-imports');

    try {
      Excel::import(new DiscountsImport($filePath), $file);


      Storage::delete($filePath);

      return redirect()->back()->with('message', 'Discount imported successfully.');
    } catch (\Exception $e) {
      dd($e);
      Storage::delete($filePath);
      return redirect()->back()->with('error', 'Failed to import discounts: ' . $e->getMessage());
    }
  }

  public function show($id)
  {
    $data = Discount::where('id', $id)->first();
    // dd($data);
    return view('website.detail_discount', compact('data'));
  }
}
