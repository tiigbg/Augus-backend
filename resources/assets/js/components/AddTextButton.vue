<template>
    
    <div>
        <span v-if="!editmode" v-on:click="editmode = !editmode">
            {{ text }}
            <button >{{button}}</button>
        </span>
        <form v-if="editmode" v-bind:action="action" method="POST">
            <input type="text" name="text" v-bind:value="text" />
            <input type="hidden" name="type" v-bind:value="type" />
            <input type="text" name="language" v-bind:value="language" size="2"/>
            <input type="submit" name="submit" value="Add"/>
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
        props: ['button', 'type', 'text', 'language', 'parent_id', 'action', 'csrf_token', 'method']
    }
</script>
