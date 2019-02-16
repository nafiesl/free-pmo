<?php

namespace App\Http\Requests;

use App\Entities\Projects\Project;
use App\Entities\Subscriptions\Subscription;

class SubscriptionRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('manage_subscriptions');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'PATCH':
                return $this->getUpdateRules();
                break;

            case 'DELETE':
                return $this->getDeleteRules();
                break;

            default:
                return $this->getCreateRules();
                break;
        }
    }

    public function getCreateRules()
    {
        return [
            'name'       => 'required|max:60',
            'price'      => 'required|numeric',
            'start_date' => 'required|date|date_format:Y-m-d',
            'due_date'   => 'required|date|date_format:Y-m-d',
            'project_id' => 'required|numeric|exists:projects,id',
            'vendor_id'  => 'required|numeric|exists:vendors,id',
            'type_id'    => 'required|numeric',
            'notes'      => 'nullable|max:255',
        ];
    }

    public function getUpdateRules()
    {
        return [
            'name'       => 'required|max:60',
            'price'      => 'required|numeric',
            'start_date' => 'required|date|date_format:Y-m-d',
            'due_date'   => 'required|date|date_format:Y-m-d',
            'project_id' => 'required|numeric|exists:projects,id',
            'vendor_id'  => 'required|numeric|exists:vendors,id',
            'type_id'    => 'required|numeric',
            'notes'      => 'nullable|max:255',
        ];
    }

    public function getDeleteRules()
    {
        // dd($this->route('subscription'));
        // dd($this->all(), $this->segment(2));
        return [
            'subscription_id' => 'required|in:'.$this->segment(2),
        ];
    }

    public function approveToCreate(Subscription $subscription)
    {
        $project = Project::findOrFail($this->get('project_id'));

        $subscription->project_id = $project->id;
        $subscription->vendor_id = $this->get('vendor_id');
        $subscription->customer_id = $project->customer_id;
        $subscription->name = $this->get('name');
        $subscription->price = $this->get('price');
        $subscription->start_date = $this->get('start_date');
        $subscription->due_date = $this->get('due_date');
        $subscription->type_id = $this->get('type_id');
        $subscription->notes = $this->get('notes');

        $subscription->save();

        return $subscription;
    }

    public function approveToUpdate(Subscription $subscription)
    {
        $project = Project::findOrFail($this->get('project_id'));

        $subscriptionData = $this->except(['_method', '_token']);
        $subscriptionData['customer_id'] = $project->customer_id;

        $subscription->update($subscriptionData);

        return $subscription;
    }

    public function approveToDelete(Subscription $subscription)
    {
        $subscription->delete();
    }
}
