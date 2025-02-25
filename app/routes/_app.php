<?php

app()->get('/', function () {
    /**
     * `render(view, [])` is the same as `echo view(view, [])`
     */
    render('index');
});

app()->get('/que-es-una-visa', ['name' => 'about-visa', function () {render('what_is_avisa');}]);