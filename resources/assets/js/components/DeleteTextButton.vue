<template>
    <span class="deletetextbutton">
        <form v-bind:action="action" method="POST">
            <button type="submit" name="submit" class="btn btn-danger">
                <span v-if="icon" v-bind:class="icon" aria-hidden="true"></span>
                {{ button }}
            </button>
            <input type="hidden" name="_token" v-bind:value="csrf_token">
            <input type="hidden" name="_method" v-bind:value="method">
        </form>
    </span>
</template>

<script>
    export default {
        mounted() {
        },
        props: {
            button: {
                type: String,
                default: 'Delete'
            },
            action: String,
            csrf_token: String,
            method: String,
            icon: String
        }
    }
</script>
