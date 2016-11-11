<template>
    
    <div>
        <form v-bind:action="action" method="POST">
            <input type="submit" name="submit" v-bind:value="button"/>
            <input type="hidden" name="_token" v-bind:value="csrf_token">
            <input type="hidden" name="_method" v-bind:value="method">
        </form>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component ready.')
        },
        props: {
            button: {
                type: String,
                default: 'Delete'
            },
            action: String,
            csrf_token: String,
            method: String
        }
    }
</script>
