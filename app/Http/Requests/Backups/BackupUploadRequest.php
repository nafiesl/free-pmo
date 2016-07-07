<?php

namespace App\Http\Requests\Backups;

use App\Http\Requests\Request;

class BackupUploadRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return auth()->user()->can('manage_backups');
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'backup_file' => 'required|sql_zip'
		];
	}

	public function messages()
	{
		return [
			'file.sql_zip' => 'Isian file harus dokumen berjenis .zip, .gz atau .sql',
		];
	}

	protected function getValidatorInstance()
	{
	    $validator = parent::getValidatorInstance();

	    $validator->addImplicitExtension('sql_zip', function($attribute, $value, $parameters) {
	    	if ($value)
	    		return in_array($value->getClientOriginalExtension(), ['zip','gz','sql']);

	    	return false;
	    });

	    return $validator;
	}

}
