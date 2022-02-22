<?php

namespace App\Core\Repositories\General;

use App\Core\Interfaces\General\ItemInterface;
use App\Models\General\Item;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ItemRepository implements ItemInterface
{
    public function getAll()
    {
        $items = Item::orderBy('id','desc')
                    ->paginate(10);

        $items->getCollection()->transform(function ($data) {
            return $this->response($data);
        });
                    
        return $items;
    }

    public function findById($id)
    {
        $tax = Item::find($id);
        return $this->response($tax);
    }

    public function create($request)
    {
        $buyAmount = preg_replace( '/[^0-9]/', '', $request->buy_price );
        $sellAmount = preg_replace( '/[^0-9]/', '', $request->sell_price );

        $data = [
            'category_id'    => $request->category_id,
            'code'           => $request->code,
            'name'           => $request->name,
            'inventory_type' => $request->inventory_type == 'on' ? 1 : 0, 
            'buy_price'      => $buyAmount,
            'sell_price'     => $sellAmount,
            'unit_id'        => $request->unit_id,
            'buy_tax_id'     => $request->buy_tax_id,
            'sell_tax_id'    => $request->sell_tax_id,
            'note'           => $request->note,
        ];

        $tax = Item::create($data);

        return $tax;    
    }

    public function update($request, $id)
    {
        $buyAmount = preg_replace( '/[^0-9]/', '', $request->buy_price );
        $sellAmount = preg_replace( '/[^0-9]/', '', $request->sell_price );

        $data = [
            'category_id'    => $request->category_id,
            'code'           => $request->code,
            'name'           => $request->name,
            'inventory_type' => $request->inventory_type == 'on' ? 1 : 0, 
            'buy_price'      => $buyAmount,
            'sell_price'     => $sellAmount,
            'unit_id'        => $request->unit_id,
            'buy_tax_id'     => $request->buy_tax_id,
            'sell_tax_id'    => $request->sell_tax_id,
            'note'           => $request->note,
        ];

        $item = Item::find($id);
        $item->update($data);
        
        return $item; 
    }

    public function delete($id)
    {
        $item = Item::find($id);
        $item->delete();

        return $item;
    }

    public function response($item)
    {
        return [
            'id'                  => $item->id,
            'code'                => $item->code,
            'name'                => $item->name,
            'category'            => $item->category->name,
            'category_id'         => $item->category_id,
            'inventory'           => $item->inventory_type,
            'unit'                => $item->unit->name,
            'unit_id'             => $item->unit_id,
            'purchaseTax'         => $item->buyTax->code,
            'purchaseTaxID'       => $item->buy_tax_id,
            'saleTax'             => $item->sellTax->code,
            'saleTaxID'           => $item->sell_tax_id,
            'note'                => $item->note,
            'buyPrice'            => $item->buy_price,
            'sellPrice'           => $item->sell_price,
            'created_by'          => $item->created_by,
            'user_name'           => $item->user->name,
            'status'              => $item->status,
            'created_at'          => Carbon::parse($item->created_at)->format('d M Y h:m:s A'),
            'updated_at'          => Carbon::parse($item->updated_at)->format('d M Y h:m:s A'),
        ];
    }
}