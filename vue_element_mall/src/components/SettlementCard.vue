<template>
  <el-container direction="vertical">
    <div class="main_content">
      <el-row>
        <el-col :span="24">
          <div style="margin-top: 20px;"><p class="black_p">确人收货地址</p></div>
          <el-divider></el-divider>
        </el-col>
      </el-row>
      <div class="address">
        <el-radio-group v-model="radio" >
          <div class="address_item">
            <el-radio :label="3">备选项</el-radio>
          </div>
          <div class="address_item">
            <el-radio :label="6">备选项</el-radio>
          </div>
          <div class="address_item">
            <el-radio :label="9">备选项</el-radio>
          </div>

        </el-radio-group>
      </div>
    </div>
    <div class="settlementPage_item">
    <div class="settlementCard_nav">
      <el-row>
        <el-col :span="24">
          <div style="margin-bottom: 30px;"><p class="black_p">确认订单信息</p></div>
        </el-col>
      </el-row>
      <el-row>
        <el-col :span="24">
          <span style="margin-left: 265px;">商品信息</span>
          <span style="margin-left: 475px;">单价</span>
          <span style="margin-left: 145px;">数量</span>
          <span style="margin-left: 85px;">小计</span>
        </el-col>
      </el-row>
    </div>
    <el-row>
      <el-col :span="24" v-for="(i) in items" :key="i.id">
        <el-card :body-style="{padding:'0px'}"  shadow="none">
          <div class="goods_img">
            <img :src="i.goods_big_logo" class="image">
          </div>
          <div class="goods_title">
            <p>{{ i.goods_name }}</p>
          </div>
          <div class="goods_introduce">

          </div>
          <div class="goods_price">
            <p>￥{{i.price}}</p>
          </div>
          <div class="goods_num">{{ i.number }}</div>
          <div class="goods_total">
            <p>￥{{ i.total }}</p>
          </div>
        </el-card>
      </el-col>
    </el-row>
      <div class="calculation">
        <el-row>
          <el-col :span="24">
            <div class="panel">
              <div class="total">
                <span class="total_price">￥66666</span>
                <p class="total_title">实付款：</p>
              </div>
              <div class="final_address">
                <span class="user_address">广东省 东莞市 松山湖管委会 大学路1号东莞理工学院松山湖校区小麦公社</span>
                <p class="user_address_title">寄送至：</p>
              </div>
              <div class="user">
                <span class="user_info">梁伟舜 13539456252</span>
                <p class="user_title">收货人：</p>
              </div>
            </div>
            <div class="submit_button">
              <el-button type="danger" >提交订单</el-button>
            </div>
            <div class="return_card">
              <el-link :underline="false" type="primary" icon="el-icon-back" href="/AboutMe?selectedTag=2">返回购物车</el-link>
            </div>
          </el-col>
        </el-row>
      </div>
    </div>
  </el-container>
</template>

<script>
export default {
  name: "SettlementCard",
  data(){
    return{
      radio:3,
      items:[],

    }
  },
  methods:{
    getCartItem(data){
      this.$api.cart.showCartItem(data).then(res=>{
            this.items=res.data.message;
          })
          .catch(err=>{
            console.log(err);
          })
    },
  },
  props:[
    'cart_id',
  ],
  created() {
    this.getCartItem(this.cart_id)
  }
}
</script>

<style scoped>

.main_content{
  width: 1280px;

  margin:0 auto;
}
.black_p{
  display: block;
  font-family: "Helvetica Neue",Helvetica,"PingFang SC","Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
  font-weight: 700;
  font-size: 15px;
}
.address_item{
  width: 1280px;
  height: 25px;

}
.el-radio{
  margin-top: 5px;
}

.settlementPage_item{
  width: 1280px;
  margin: 20px auto;


}
.settlementCard_nav{
  width: 1380px;
  height: 30px;
  margin: 0 auto;

}
.black_p{
  display: block;
  font-family: "Helvetica Neue",Helvetica,"PingFang SC","Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
  font-weight: 700;
  font-size: 15px;
}
.el-card{
  height: 160px;
  width: 1260px;
  margin: 15px auto;
}
.goods_img img{
  height: 120px;
  width: 200px;
  margin-left: 50px;
  margin-top: 20px;
  float: left;
}
.image {
  height: 120px;
  width: 180px;
  display: block;
}
.goods_title{
  height: 120px;
  width: 280px;
  float: left;
  margin-top: 20px;
  margin-left: 10px;
}
.goods_title p{
  color: #000000;
}
.goods_introduce{
  height: 120px;
  width: 230px;

  float: left;
  margin-top: 20px;
  margin-left: 10px;
}
.goods_price{
  height: 120px;
  width: 100px;

  float: left;
  margin-top: 20px;
  margin-left: 10px;
}
.goods_price p{
  display: block;
  font-size: 20px;
  font-family: "Microsoft YaHei";
}
.goods_price{
  height: 120px;
  width: 100px;
  float: left;
  margin-top: 20px;
  margin-left: 10px;
}
.goods_num{
  height: 120px;
  width: 90px;
  float: left;
  margin-top: 20px;
  margin-left: 90px;

}

.goods_total{
  height: 120px;
  width: 100px;
  float: left;
  margin-top: 20px;
  margin-left: 10px;

}
.goods_total p{

  display: block;

  font-size: 20px;
  font-family: "Microsoft YaHei";
  color: red;
}
.calculation{
  height: 220px;
  width: 1280px;

}
.panel{
  width: 570px;
  height: 140px;
  float: right;
  margin-right: 20px;
  margin-top: 20px;
  border: 1px #DCDFE6 solid;
}
.total{

  height: 50px;
  margin-top: 10px;
}
.total_title{

  width: 60px;
  display: block;
  margin-top: 21px;
  font-size: 14px;
  font-weight: 700;
  float: right;
}
.total_price{
  height: 40px;
  width: auto;
  float: right;

  margin-right: 5px;
  font-size: 30px;
  line-height: 55px;
  color: red;
}
.final_address{

  height: 30px;

}
.user_address_title{

  width: 60px;
  display: block;
  margin-top:10px;
  font-size: 14px;
  font-weight: 700;
  float: right;
}
.user_address{
  width: auto;
  height: 20px;
  clear: both;
  float: right;

  margin-top: 9px;
  margin-right: 5px;
  font-size: 2px;
  line-height: 22px;
  color: black;
}
.user{

  height: 30px;
}
.user_title{

  width: 60px;
  display: block;
  margin-top:10px;
  font-size: 14px;
  font-weight: 700;
  float: right;
}
.user_info{
  width: auto;
  height: 20px;
  clear: both;
  float: right;
  margin-top: 9px;
  margin-right: 5px;
  font-size: 2px;
  line-height: 22px;
  color: black;
}
.submit_button{

  width: 97px;
  margin-top: 5px;
  margin-right: 20px;
  clear: both;
  float: right;
}
.return_card{

  width: 97px;
  margin-top: 15px;
  margin-right:20px;
  float: right;
}
.el-button{
}
</style>