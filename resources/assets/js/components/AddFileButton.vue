<template>
    <div>
        <span v-if="!editmode" v-on:click="editmode = !editmode">
            <button class="addbutton btn btn-success">
                <span v-if="icon" v-bind:class="icon" aria-hidden="true"></span>
                {{button}}
            </button>
        </span>
        <form v-if="editmode" v-bind:action="action" enctype="multipart/form-data" method="POST">
            <div class="row">
                <div class="col-md-6">
                    <input class="form-control" v-bind:name="name" type="file">
                    <input v-if="language_enabled" type="text" name="language" v-bind:value="language" size="2"/>
                </div>
                <div class="col-md-6">
                    <input type="hidden" name="_token" v-bind:value="csrf_token">
                    <input type="hidden" name="_method" v-bind:value="method">
                    <input type="hidden" name="parent_id" v-bind:value="parent_id">
                    <input type="hidden" name="parent_type" v-if="parent_type" v-bind:value="parent_type" />
                    <button type="submit" class="btn btn-success">Upload</button>
                    <button type="reset" class="btn btn-default" v-on:click="editmode = !editmode">Cancel</button>
                </div>
            </div>
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
            language: {
                type: String,
                default: 'en'
            },
            button: String,
            icon: String,
            name: String,
            parent_id: String,
            parent_type: String,
            action: String,
            csrf_token: String,
            method: String,
            language_enabled: {
                type: Boolean,
                default: true
            },
        }
    }
</script>
