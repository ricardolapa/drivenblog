<template>
    <div>
        <div class="card" style="margin-bottom:40px">
            <!-- <img class="card-img-top" src=".../100px180/" alt="Card image cap"> -->
            <div class="card-body" style="padding:50px">
                <h2 class="card-title">{{ title }}</h2>
                <p class="card-text">{{ description }}</p>
                <small>Posted at {{ date.date }} | by: {{ author }}</small>
            </div>
        </div>
    </div>
</template>
 
<script>
    export default {
        name: "blog-article",
        props: [
            // 'post',
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