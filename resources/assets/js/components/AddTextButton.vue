<template>
    
    <div>
        <span v-if="!editmode" v-on:click="editmode = !editmode">
            {{ text }}
            <button >{{button}}</button>
        </span>
        <form v-if="editmode" v-bind:action="action" method="POST">
            <textarea name="text" v-bind:rows="rows" v-bind:cols="cols">{{ text }}</textarea> 
            <input type="hidden" name="type" v-bind:value="type" />
            <input type="hidden" name="parent_type" v-bind:value="parent_type" />
            <input type="text" name="language" v-bind:value="language" size="2"/>
            <input type="submit" name="submit" value="Add"/>
            <input type="reset" value="Cancel" v-on:click="editmode = !editmode"/>
            <input type="hidden" name="_token" v-bind:value="csrf_token">
            <input type="hidden" name="_method" v-bind:value="method">
            <input type="hidden" name="parent_id" v-bind:value="parent_id">
        </form>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                editmode: false
            }
        },
        mounted() {
            console.log('Component ready.')
        },
        props: {
            button: {
                type: String,
                default: 'Add text'
            },
            text: {
                type: String,
                default: ''
            },
            type: {
                type: String,
                default: 'title'
            },
            language: {
                type: String,
                default: 'en'
            },
            rows: {
                type: String,
                default: '1'
            },
            cols: {
                type: String,
                default: '50'
            },
            parent_id: String,
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
