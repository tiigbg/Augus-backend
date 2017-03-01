<template>
    
    <span>
        <form v-bind:action="action" method="POST">
            <input type="submit" v-if="visibility === 'visible'" name="submit" value="Hide" class="btn btn-primary"/>
            <input type="hidden" v-if="visibility === 'visible'" name="visibility" value="hidden">
            {{visibility}}
            <input type="submit" v-if="visibility === 'hidden'" name="submit" value="Publish" class="btn btn-warning"/>
            <input type="hidden" v-if="visibility === 'hidden'" name="visibility" value="visible">

            <input type="hidden" name="_token" v-bind:value="csrf_token">
            <input type="hidden" name="_method" v-bind:value="method">
            <input type="hidden" name="id" v-bind:value="id">
        </form>
    </span>
</template>

<script>
    export default {
        mounted() {
        },
        props: {
            id: String,
            action: String,
            method: String,
            csrf_token: String,
            visibility: String
        }
    }
</script>
