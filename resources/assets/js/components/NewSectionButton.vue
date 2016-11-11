<template>
	<div>
	    <form v-bind:action="action" method="POST">
			<input type="submit" name="submit" value="Add section"/>
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
        props: ['parent_id','csrf_token', 'action']
    }
</script>
