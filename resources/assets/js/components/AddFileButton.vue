<template>
    
            

    <div>
        <span v-if="!editmode" v-on:click="editmode = !editmode">
            <button >{{button}}</button>
        </span>
        <form v-if="editmode" v-bind:action="action" enctype="multipart/form-data" method="POST">
            <div class="row">
                <div class="col-md-6">
                    <input class="form-control" v-bind:name="name" type="file">
                </div>
                <div class="col-md-6">
                    <input type="hidden" name="_token" v-bind:value="csrf_token">
                    <input type="hidden" name="_method" v-bind:value="method">
                    <input type="hidden" name="parent_id" v-bind:value="parent_id">
                    <button type="submit" class="btn btn-success">Upload</button>
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
        props: ['button', 'name', 'parent_id', 'action', 'csrf_token', 'method']
    }
</script>
