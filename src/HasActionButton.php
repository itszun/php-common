<?php

namespace Itszun\Common;

/**
 * Basic Action Button Implements
 *
 * Customize button output by implements actionButtonOptions() on Model
 *
 */

trait HasActionButton {
    public function getActionButtonAttribute() {
        return $this->actionButton($this->id);
    }

    public function actionButtonOptions() {
        return [
            'button#1' => [
                'icon' => 'fa fa-eye',
                'url' => "",
            ],
            'button#2' => [
                'icon' => 'fa fa-trash',
                'url' =>  "#",
            ],
        ];
    }

    public function actionButton($id, $option = []) {
        $action = collect($this->actionButtonOptions());
        $buttons = empty($option) ? $action : $action->filter(fn ($v, $k) => in_array($k, $option));
        return view('admin.components.actionButton', compact('buttons'))->render();
    }
}
