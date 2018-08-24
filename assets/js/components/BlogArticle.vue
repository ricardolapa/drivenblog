<template>
    <div>
        <div class="card" >
            <!-- <img class="card-img-top" src=".../100px180/" alt="Card image cap"> -->
            <div class="card-body">
                <h5 class="card-title">{{ title }}</h5>
                <p class="card-text">{{ description }}</p>
                <small>{{ author }}</small>
            </div>
        </div>
    </div>
</template>
 
<script>
    export default {
        name: "blog-article",
        props: [
            'title',
            'image',
            'description',
            'author',
            'date'
        ],
        data () {
            return {
            }
        }
    }
</script>
 
<style scoped>
 
</style>