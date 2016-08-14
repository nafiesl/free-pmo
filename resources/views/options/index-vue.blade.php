@extends('layouts.guest')

@section('content')
<h1 class="page-header">Options</h1>

<div id="vue-el">
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-1">ID</div>
                <div class="col-md-4">Key</div>
                <div class="col-md-5">Value</div>
                <div class="col-md-2">Option</div>
            </div>
            <div class="row" v-for="option in options">
                <options-row :option="option" :options="options"></options-row>
            </div>
            <div class="row">
                <options-new :newOption="newOption" :options="options"></options-new>
            </div>
        </div>
    </div>
</div>

<template id="option-row-template">
    <div v-show="!inEditMode">
        <div class="col-md-1">@{{ option.id }}</div>
        <div class="col-md-4">@{{ option.key }}</div>
        <div class="col-md-5">@{{ option.value }}</div>
        <div class="col-md-2">
            <button class="btn btn-info btn-xs" v-on:click="editForm">Edit</button>
        </div>
    </div>
    <div v-show="inEditMode">
        <div class="col-md-1">@{{ option.id }}</div>
        <div class="col-md-4">
            <input v-model="option.key" v-on:keyup.esc="cancelEditMode" type="text" class="form-control" />
        </div>
        <div class="col-md-5">
            <input v-model="option.value" v-on:keyup.esc="cancelEditMode" type="text" class="form-control" />
        </div>
        <div class="col-md-2">
            <button class="btn btn-info btn-xs" v-on:click="update(option)">update</button>
            <button class="btn btn-danger btn-xs" v-on:click="deleteOpt(option)">x</button>
        </div>
    </div>
</template>

<template id="option-new-template">
    <form action="#" method="post" v-on:submit.prevent="addNewOption">
            <div class="col-md-1">&nbsp;</div>
            <div class="col-md-4">
                <input type="text" id="key" name="key" class="form-control" v-model="newOption.key" placeholder="Add new Option key">
            </div>
            <div class="col-md-5">
                <textarea id="value" name="value" class="form-control" v-model="newOption.value" placeholder="Add new Option value"></textarea>
            </div>
            <div class="col-md-2">
                <input type="submit" value="Submit" class="btn btn-success">
            </div>
    </form>
</template>

@endsection
@section('ext_js')
    {!! Html::script(url('assets/js/plugins/vue.min.js')) !!}
    {!! Html::script(url('assets/js/plugins/vue-resource.min.js')) !!}
@endsection
@section('script')
<script>

Vue.component('options-row', {
    data: function() {
        return {
            inEditMode: false
        }
    },
    props: ['option','options'],
    template: '#option-row-template',
    methods: {
        editForm: function() {
            this.inEditMode = true;
        },
        update: function(option) {
            this.$http.patch('api/options/' + option.id, option);

            this.inEditMode = false;
        },
        cancelEditMode: function() {
            this.inEditMode = false;
        },
        deleteOpt: function(option) {
            var confirmBox = confirm('Delete this option?');

            if (confirmBox) {
                this.$http.delete('api/options/' + option.id);
                // console.log (this.options);
                this.options.$remove(option);
                // this.options.splice(id, 1);
                // console.log (this.options);
                // this.fetchOptions();
            }

            this.inEditMode = false;
        }
    }
});

Vue.component('options-new', {
    data: function() {
        return {
            newOption: {
                key: '',
                value: ''
            }
        }
    },
    props: ['options'],
    template: '#option-new-template',

    methods: {
        addNewOption: function() {
            // New Option Input
            var option = this.newOption;

            // Clear form
            this.newOption = { key: '', value: '' }

            // Send post request
            this.$http.post('api/options', option, function(data) {
                this.options.push(data);
            });
        }
    }
});

var vm = new Vue({
    http: {
        headers: {
            'X-CSRF-Token': "{{ csrf_token() }}"
        }
    },

    el: "#vue-el",

    methods: {
        fetchOptions: function() {
            this.$http.get('api/options', function(data) {
                this.$set('options', data);
            });
        }
    },

    ready: function() {
        this.fetchOptions();
    }
});
</script>
@endsection

@section('style')
<style>
    .success-transition {
        transition: all .5s ease-in-out;
    }
    .success-enter, .success-leave {
        opacity: 0;
    }
</style>
@endsection