<template>
  <div class="main">
      <el-card :body-style="{ padding: '0px' }" @click.native="test()" :title="goods_name">
        <div class="goods_img">
          <img src="https://shadow.elemecdn.com/app/element/hamburger.9cf7b091-55e9-11e9-a976-7f4d0b07eef6.png" class="image">
        </div>
        <div  class="goods_info" >
          <div  class="goods_title">
            <span>好吃的汉堡</span>
          </div>
          <div class="goods_price">
            <span>￥299.00</span>
          </div>
          <div class="cart_icon">
            <div>
              <i class="el-icon-shopping-cart-1"></i>
            </div>

          </div>
        </div>
      </el-card>
  </div>
</template>

<script>
export default {
  name: "GoodsCard",
  data(){
    return{
        goods_name:'好吃的汉堡',
    }
  },
  methods:{
    test(){
      //alert("test");
    },
  },
  mounted(){
    this.$api.goods.pageSearch(1, 10)
        .then(res => {
          console.log(res.data)
        })
        .catch(err => {
          console.log(err)
        })
  }
}
</script>

<style scoped>
.main{
  margin-left:20px;
  width:240px;
  height: 320px;
}

.image {
  width: 100%;
  display: block;
}

.el-card{
  height: 280px;
  width: 220px;
  cursor: pointer;
  margin: 15px auto;
}
.goods_info{
  height: 70px;
  width: 220px;
}
.goods_img img{
  height: 210px;
  width: 220px;
}
.goods_title{
  width: 210px;
  height: 20px;
  float: left;
}
.goods_title span{
  margin-left: 10px;
  width: 210px;
  text-align: left;
  color: #696969;
  white-space: nowrap;
  overflow: hidden;
  text-overflow:ellipsis;
  float: left;
}
.goods_price{
  height: 50px;
  width: 140px;

  float:left;
}
.goods_price span{
  margin: 10px 0 0 10px;
  font-size: 18px;
  color: skyblue;
  display: block;

}
.cart_icon{
  height: 50px;
  width: 60px;
  margin-left: 8px;
  float:left;
}
.cart_icon div{
  height: 30px;
  width: 30px;
  margin: 8px 0 0 28px;
}
i{
  font-size: 25px;
}

</style>