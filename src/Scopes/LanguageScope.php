<?php

namespace Gwaps4nlp\Core\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Gwaps4nlp\Core\Models\Language;
use App;

class LanguageScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $language_id = Language::getIdBySlug(App::getLocale());
        $builder->where('language_id', '=', $language_id);
    }
}