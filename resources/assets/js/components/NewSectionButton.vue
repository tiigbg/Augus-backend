<template>
	<div>
	    <form v-bind:action="action" method="POST">
	    	<button type="submit" class="addbutton btn btn-success">
                <span v-if="icon" v-bind:class="icon" aria-hidden="true"></span>
                Add section
            </button>
			<input type="hidden" name="_token" v-bind:value="csrf_token">
			<input type="hidden" name="parent_id" v-bind:value="parent_id">
		</form>
	</div>
</template>

<script>
	
    export default {
        mounted() {
            console.log('Component ready.')
        },
        props: ['icon','parent_id','csrf_token', 'action']
    }
</script>
