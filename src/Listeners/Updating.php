<?php

namespace Wildside\Userstamps\Listeners;

use Illuminate\Support\Facades\Auth;
use Sentry;

class Updating
{
    /**
     * When the model is being updated.
     *
     * @param  Illuminate\Database\Eloquent  $model
     * @return void
     */
    public function handle($model)
    {
        if (! $model->isUserstamping() || is_null($model->getUpdatedByColumn()) || is_null(Sentry::getUser()->id)) {
            return;
        }

        $model->{$model->getUpdatedByColumn()} = Sentry::getUser()->id;
    }
}
