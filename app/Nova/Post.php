<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Post extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Post::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Author', 'author', User::class)->nullable(),

            Text::make('Title')->required(),

            Boolean::make('No author')
                ->help('This field may only be checked when no author is selected.')
                ->dependsOn(['author'], function (Field $field, NovaRequest $request, FormData $data) {
                    if ($data->resource('author', $data->author) !== null) {
                        $field->hide();
                    }
                })
        ];
    }
}
