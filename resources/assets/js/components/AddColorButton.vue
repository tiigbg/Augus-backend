<template>
    
    <div>
        <span v-if="!editmode" v-on:click="editmode = !editmode">
            <span v-bind:style="{ backgroundColor: dark_color, width: '15px', height:'15px', display:'inline-block' }"></span>
            <span v-bind:style="{ backgroundColor: light_color, width: '15px', height:'15px', display:'inline-block' }"></span>
            <button >{{button}}</button>
        </span>
        <form v-if="editmode" v-bind:action="action" method="POST">
            dark: <input type="text" name="dark_color" v-bind:value="dark_color"></input> 
            light: <input type="text" name="light_color" v-bind:value="light_color"></input> 
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
                default: 'Add color'
            },
            dark_color: {
                type: String,
                default: ''
            },
            light_color: {
                type: String,
                default: ''
            },
            parent_id: String,
            action: String,
            method: String,
            csrf_token: String
        }
    }
</script>
