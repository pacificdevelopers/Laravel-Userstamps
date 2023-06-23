<?php

namespace Pacificinternet\Userstamps\Listeners;

use Illuminate\Support\Facades\Auth;
use Sentry;

class Deleting
{
    /**
     * When the model is being deleted.
     *
     * @param  Illuminate\Database\Eloquent  $model
     * @return void
     */
    public function handle($model)
    {
        if (! $model->isUserstamping() || is_null($model->getDeletedByColumn())) {
            return;
        }

        if (is_null($model->{$model->getDeletedByColumn()})) {
            $model->{$model->getDeletedByColumn()} = Sentry::getUser()->id;
        }

        $dispatcher = $model->getEventDispatcher();

        $model->unsetEventDispatcher();

        $model->save();

        $model->setEventDispatcher($dispatcher);
    }
}
