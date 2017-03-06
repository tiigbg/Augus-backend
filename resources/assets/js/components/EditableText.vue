<template>
    
    <span >
        <span v-if="!editmode" v-on:click="editmode = !editmode">
            {{ language }}:{{ value }}
            <button class="btn btn-default">Edit</button>
        </span>
        <form v-if="editmode" v-bind:action="action" method="POST">
            <textarea name="text" v-bind:rows="rows" v-bind:cols="cols">{{ value }}</textarea> 
            <input type="text" name="language" v-bind:value="language" size="2"/>
            <input type="submit" name="submit" value="Save" class="btn btn-success"/>
            <input type="reset" name="cancel" value="Cancel" v-on:click="editmode = !editmode"  class="btn btn-default"/>
            <input type="hidden" name="_token" v-bind:value="csrf_token">
            <input type="hidden" name="_method" v-bind:value="method">
            <input type="hidden" name="id" v-bind:value="id">
        </form>
    </span>
</template>

<script>
    export default {
        data: function() {
            return {
                editmode: false
            }
        },
        mounted() {
        },
        props: {
            value: {
                type: String,
                default: ''
            },
            type: {
                type: String,
                default: 'title'
            },
            language: {
                type: String,
                default: 'sv'
            },
            rows: {
                type: String,
                default: '1'
            },
            cols: {
                type: String,
                default: '50'
            },
            id: String,
            parent_type: {
                type: String,
                default: 'section'
            },
            action: String,
            method: String,
            csrf_token: String
        }
    }
</script>
