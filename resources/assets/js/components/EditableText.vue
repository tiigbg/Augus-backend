<template>
    
    <div>
        <span v-if="!editmode" v-on:click="editmode = !editmode">
            {{ value }}
            <button >Edit</button>
        </span>
        <form v-if="editmode" v-bind:action="action" method="POST">
            <input type="text" v-bind:name="name" v-bind:value="value" />
            <input type="submit" name="submit" value="Save"/>
            <input type="reset" name="cancel" value="Cancel" v-on:click="editmode = !editmode" />
            <input type="hidden" name="_token" v-bind:value="csrf_token">
            <input type="hidden" name="_method" v-bind:value="method">
            <input type="hidden" name="id" v-bind:value="sectionid">
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
        },
        props: ['name', 'value', 'sectionid', 'action', 'csrf_token', 'method']
    }
</script>
