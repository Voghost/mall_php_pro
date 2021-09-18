<template>
  <el-container>


  </el-container>
</template>

<script>


export default {
  name: "404",
  components: {},
  data(){
    return{
      goods:[],
      current:1,
      size:24,
    }
  },
  methods:{
    getGoodsInfo(page=1,query=null){
      this.current=page
      this.$api.goods.pageSearch(this.current,this.size,query)
          .then(res => {
            this.goods=res.data.message.content;
            console.log(this.goods)
          })
          .catch(err => {
            console.log(err)
          })
    },
    mounted(){
      this.getGoodsInfo()
    }
  },

}
</script>

<style>

</style>
