<?php

namespace App\Entities\Invoices;

use App\Entities\Projects\Project;
use App\Entities\Users\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Invoice Model.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class Invoice extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['items' => 'array'];

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 25;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'number';
    }

    /**
     * Invoice belongs to project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Invoice belongs to creator (user).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate invoice (incrementing) number.
     *
     * @return string
     */
    public function generateNewNumber()
    {
        $prefix = date('ym');

        $lastInvoice = $this->orderBy('number', 'desc')->first();

        if (!is_null($lastInvoice)) {
            $lastInvoiceNo = $lastInvoice->number;
            if (substr($lastInvoiceNo, 0, 4) == $prefix) {
                return ++$lastInvoiceNo;
            }
        }

        return $prefix.'001';
    }

    /**
     * Get invoice items count attribute.
     *
     * @return int
     */
    public function getItemsCountAttribute()
    {
        return count($this->items);
    }

    /**
     * Get invoice number in html link format.
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function numberLink()
    {
        return link_to_route('invoices.show', $this->number, [$this->number], [
            'title' => __(
                'app.show_detail_title',
                ['name' => $this->number, 'type' => __('invoice.invoice')]
            ),
        ]);
    }
}
