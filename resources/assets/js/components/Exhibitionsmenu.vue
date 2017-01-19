<template>
    <ul>
        <li v-for="exhibition in exhibitions.exhibitions">
            <div>
            <a v-bind:href="'/section/'+exhibition.id">
                <div v-if="exhibition.titles" v-for="title in exhibition.titles" >
                    {{ title.language }}: {{ title.text }}
                </div>
                <div v-if="exhibition.titles.length==0">
                    (untitled)
                </div>
            </a>
            </div>
        </li>
    </ul>
</template>

<script>
    export default {
        data () {
            return {
                exhibitions: ''
            }
        },
        mounted() {
            console.log('Component ready.');
            this.$http.get('/allexhibitions').then((response) => {
                // success callback
                this.exhibitions = response.body;
              }, (response) => {
                // error callback
              });
        }
    }
</script>
