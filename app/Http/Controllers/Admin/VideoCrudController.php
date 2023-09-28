<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\VideoRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Video;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * Class VideoCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class VideoCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Video::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/video');
        CRUD::setEntityNameStrings('video', 'videos');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::setFromDb(); // set columns from db columns.
        CRUD::column([
            'name'      => 'title', // The db column name
            'label'     => 'Title', // Table column heading)
        ]);

        CRUD::column([
            'name'      => 'date_planned', // The db column name
            'label'     => 'Date planned', // Table column heading)
        ]);

        CRUD::column([
            'name'      => 'status', // The db column name
            'label'     => 'Status', // Table column heading)
        ]);
        
        CRUD::column([
            // run a function on the CRUD model and show its return value
            'name'  => 'video',
            'type'  => 'url',
            'label' => 'Video',
            'target' => '_blank' // let's you change link target window.
    
        ]);

        CRUD::column([
            // run a function on the CRUD model and show its return value
            'name'  => 'image',
            'type'  => 'image',
            'label' => 'image',
    
        ]);
        
        CRUD::column([
            // run a function on the CRUD model and show its return value
            'name'  => 'language',
            'label' => 'Language', // Table column heading
            'type'  => 'model_function',
            'function_name' => 'getLanguageName', // the method in your Model
    
        ]);

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(VideoRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        CRUD::field([  // Select
            'label'     => "Langauge",
            'type'      => 'select',
            'name'      => 'language_id', // the db column for the foreign key
         
            // optional
            // 'entity' should point to the method that defines the relationship in your Model
            // defining entity will make Backpack guess 'model' and 'attribute'
            'entity'    => 'language',
         
            // optional - manually specify the related model and attribute
            'model'     => "App\Models\Language", // related model
            'attribute' => 'name', // foreign key attribute that is shown to user
         
            // optional - force the related options to be a custom query, instead of all();

         ]);

         CRUD::field([   // Upload
            'name'      => 'image',
            'label'     => 'Image',
            'type'      => 'upload',
            'withFiles' => true,
            'disk' => 'storage'
        ]); 

        CRUD::field([   // select_from_array
            'name'        => 'status',
            'label'       => "Status",
            'type'        => 'select_from_array',
            'options'     => ['online' => 'online', 'offline' => 'offline'],
            'allows_null' => false,
            'default'     => 'online',
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }


    public function api(Request $request)
    {
        $locale = $request->input('locale');
        $now = Carbon::now();

        $videos = Video::whereHas('language', function ($query) use ($locale) {
            $query->where('locale', $locale);
        })
        ->where('status', 'online')
        ->where(function ($query) use ($now) {
            $query->whereNull('date_planned')
                ->orWhere('date_planned', '<=', $now);
        })
        ->get();

        // Handle case where $videos might be null or empty
        if ($videos === null || $videos->isEmpty()) {
            return response()->json([]);
        }

        return response()->json($videos);
    }


}
