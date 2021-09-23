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
        <el-radio-group v-model="radio" v-for="(i,index) in addresses" :key="i.id" >
          <div class="address_item">
            <el-radio :label="index" @change="radioChange()">{{ i.address }} ({{username}} {{i.phone}})</el-radio>
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
            <p>{{i.spec}}</p>
          </div>
          <div class="goods_price">
            <p>￥{{i.price |numFilter}}</p>
          </div>
          <div class="goods_num">{{ i.number }}</div>
          <div class="goods_total">
            <p>￥{{ i.total |numFilter}}</p>
          </div>
        </el-card>
      </el-col>
    </el-row>
      <div class="calculation">
        <el-row>
          <el-col :span="24">
            <div class="panel">
              <div class="total">
                <span class="total_price">￥{{ totalPrice |numFilter}}</span>
                <p class="total_title">实付款：</p>
              </div>
              <div class="final_address">
                <span class="user_address">{{finalAddress}}</span>
                <p class="user_address_title">寄送至：</p>
              </div>
              <div class="user">
                <span class="user_info">{{username}} {{finalPhone}}</span>
                <p class="user_title">收货人：</p>
              </div>
            </div>
            <div class="submit_button">
              <el-button type="danger" @click="submit()">提交订单</el-button>
            </div>
            <div class="return_card">
              <el-link :underline="false" type="primary" icon="el-icon-back" href="/AboutMe?selectedTag=2">返回购物车</el-link>
            </div>
          </el-col>
        </el-row>
      </div>
    </div>
    <el-dialog
        title="支付"
        :visible.sync="dialogVisible"
        width="30%"
       :before-close="handleClose">
      <span>确定支付</span>
      <span slot="footer" class="dialog-footer">
    <el-button @click="dialogVisible = false">取 消</el-button>
    <el-button type="primary" @click="handleSave">免密支付</el-button>
  </span>
    </el-dialog>
  </el-container>
</template>

<script>
export default {
  name: "SettlementCard",
  data(){
    return{
      radio:0,
      items:[],
      addresses:[],
      username:'',
      totalPrice:0,
      finalAddress:'',
      finalPhone:'',
      orderInfo:[],
      map:{},
      orderNumber:'',
      dialogVisible: false
    }
  },
  filters: {
    numFilter (value) {
      // 截取当前数据到小数点后两位
      let realVal = parseFloat(value).toFixed(2)
      return realVal
    }
  },
  inject:['reload'],
  methods:{
    getCartItem(data){
      this.$api.cart.showCartItem(data).then(res=>{
            this.items=res.data.message;
        //获取商品规格
        for(let i=0;i<this.items.length;i++){
          this.$api.cart.getKVByInfoId(this.items[i]['goods_info_id']).then(res=>{
            this.goods_info=res.data.message
            let ItemSpec=''
            for(let i=0;i<this.goods_info.length;i++){
              ItemSpec+=this.goods_info[i]['key']['spec_name']+':'
              ItemSpec+=this.goods_info[i]['value']['spec_value']+'  '
            }
            this.$set(this.items[i],'spec',ItemSpec)
          })
        }
            this.getTotalPrice()
          })
          .catch(err=>{
            console.log(err);
          })
    },
    getAddressInfo(){
      this.$api.address.getAddress().then(res=>{
        this.addresses=res.data.data;
        this.finalAddress=this.addresses[0].address
        this.finalPhone=this.addresses[0].phone
          })
      .catch(err=>{
        console.log(err);
      })
    },
    getUsername(){
      this.$api.address.getUsername().then(res=>{
        this.username=res.data.data;
      }).catch(err=>{
        console.log(err);
      })
    },
    radioChange(){
      this.finalAddress=this.addresses[this.radio].address
      this.finalPhone=this.addresses[this.radio].phone
    },
    getTotalPrice(){
      let temp=0;
      for(let i=0;i<this.items.length;i++){
        temp+=this.items[i].total
      }
      this.totalPrice=temp
    },
    submit(){
      console.log(this.cart_id)
      this.$api.cart.createOrder(this.cart_id,this.finalAddress).then(res=>{
        this.orderInfo=res.data.message
        console.log(res)
        if(res.data.meta.status!==200){
          this.$message({
            message: '库存不够',
            type: 'warning'
          });
        }else{
          this.orderNumber=this.orderInfo.order_number
          this.dialogVisible=true
        }
        // for(let i=0;i<this.cart_id.length;i++){
        //   this.$api.cart.deleteCartItem(this.cart_id[i])
        // }
      }) .catch(err=>{
        console.log(err);
      })
      //删除购物车

    },
    handleClose() {
      this.dialogVisible=false
      this.$message({
        message: '放弃购买',
        type: 'warning'
      });
      this.$router.push({
        path:'/AboutMe?selectedTag=3'
      })
    },
    handleSave(){
      this.$api.cart.pay(this.orderNumber)
      this.dialogVisible=false
      this.$message({
        message: '购买成功',
        type: 'success'
      });
      this.reload()
      this.$router.push({
        path:'/AboutMe?selectedTag=3'
      })
    }

  },
  props:[
    'cart_id',
  ],
  created() {
    this.getCartItem(this.cart_id)
    this.getAddressInfo()
    this.getUsername()
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
.goods_introduce p{
  display: block;
  font-size: 15px;
  font-family: "Microsoft YaHei";
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