<template>
    <span class="deletebutton">
    <span v-bind:class="buttonicon" aria-hidden="true"></span>
        <button v-if="!sure" v-on:click="sure=true" >
            <span v-if="icon" v-bind:class="icon" aria-hidden="true"></span>
            {{ button }}
        </button>
        <form v-if="sure" v-bind:action="action" method="POST">
            Delete including all contents, are you sure?
            <input type="submit" name="submit" value="Yes"></input>
            <input type="reset" name="cancel" value="No" v-on:click="sure=false" />
            <input type="hidden" name="_token" v-bind:value="csrf_token">
            <input type="hidden" name="_method" value="delete">
            <input type="hidden" name="id" v-bind:value="sectionid">
        </form>
    </span>
</template>

<script>
    export default {
        data: function() {
            return {
                sure: false
            }
        },
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
            sectionid: String,
            icon: String
        }
    }
</script>
