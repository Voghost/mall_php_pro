<template>
  <el-container>
    <div class="cart_item">
      <div class="cart_nav">
        <el-row>
          <el-col :span="24">
            <input type="checkbox" :checked="allCheck" @click="allChecked()">全选
            <span style="margin-left: 205px;">商品信息</span>
            <span style="margin-left: 465px;">单价</span>
            <span style="margin-left: 145px;">数量</span>
            <span style="margin-left: 85px;">金额</span>
            <span style="margin-left: 123px;">操作</span>
          </el-col>
        </el-row>
      </div>
      <el-row>
        <el-col :span="24" v-for="(i,index) in items" :key="i.id">
          <el-card :body-style="{padding:'0px'}"  shadow="none">
            <div class="goods_check">
              <input type="checkbox"  :value="index" @click=checked() v-model="arr">
            </div>
            <div class="goods_img">
              <router-link :to="{path:'/goodsDetail',query:{goods_id:i.goods_id,}}" target="_blank">
              <el-popover placement="right-start" title="" trigger="hover">
                  <img  :src="i.goods_big_logo" style="width:300px;height: 300px">
                <img slot="reference" :src="i.goods_big_logo" class="image">
              </el-popover>
              </router-link>
            </div>
            <div class="goods_title">
              <router-link :to="{path:'/goodsDetail',query:{goods_id:i.goods_id,}}" target="_blank"><p>{{i.goods_name}}</p></router-link>
            </div>
            <div class="goods_introduce">
              <p>{{ i.spec }}</p>
            </div>
            <div class="goods_price">
              <p>￥{{ i.price }}</p>
            </div>
            <div class="goods_num">
              <el-input-number v-model="i.number" @change="handleChange(index,i.id,i.number)" :min="1" :max="99" label="描述文字"></el-input-number>
            </div>
            <div class="goods_total">
              <p>￥{{ i.total | numFilter}}</p>
            </div>
            <div class="operation">
              <p><el-button type="text" @click="deleteItem(i.id)">删除</el-button></p>
            </div>
          </el-card>
        </el-col>
      </el-row>
      <div class="cart_footer" >
        <el-row>
          <el-col :span="24">
            <router-link :to="{path:this.url,
            query:{
              cart_id:cart_id
            }}">
              <el-button type="danger" style="margin-right: 60px;float: right" @click="calculation()" :disabled="button">结算</el-button>
            </router-link>
            <span style="width: 150px;margin-top:10px;display: block;float: right">合计:<span style="color: red;">{{this.totalPrice | numFilter}}</span></span>
            <span style="width: 120px;margin-top:10px;display: block;float:right">已选商品<span style="color: red">{{this.arr.length}}</span>件</span>

          </el-col>
        </el-row>
      </div>
    </div>

  </el-container>
</template>

<script>

export default {
  name: "CartCard",

  data(){
    return{
      num:1,
      allCheck:false,
      totalPrice:0,
      items:[],
      goods_info:[],
      arr: [],
      cart_id:[],
      button:true,
      url:'/AboutMe?selectedTag=2',

    };
  },
  filters: {
    numFilter (value) {
      // 截取当前数据到小数点后两位
      let realVal = parseFloat(value).toFixed(2)
      return realVal
    }
  },
  inject:['reload'],
  methods: {
    getCartInfo(){
      this.$api.cart.allCartItem()
      .then(res=>{
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
      })
      .catch(err=>{
        console.log(err);
      })
    },
    //修改数量
    handleChange(index,id,number) {
      this.$api.cart.changeNumber(id,number)
      this.ItemTotalMoney(index)
      this.TotalMoney()
    },
    //删除
    deleteItem(id) {
      this.$confirm('删除商品?', '删除商品', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        this.$api.cart.deleteCartItem(id)

        this.reload()
        this.$message({
          type: 'success',
          message: '删除成功!',
        });
        this.$router.push({
          path:'/AboutMe?selectedTag=2'
        })
      })
          .catch(() => {
        this.$message({
          type: 'info',
          message: '已取消删除'
        });
      });
    },
    //单选
    checked() {
      if(this.items.length>this.arr.length)
      {
        this.allCheck=false
        if(this.arr.length>0) {
          this.button = false
          this.url="/SettlementPage"
        }
        else
        {
          this.button=true
          this.url="/AboutMe?selectedTag=2"
        }
      }
      if(this.items.length===this.arr.length)
      {
        this.allCheck=true
        if(this.arr.length>0) {
          this.button = false
          this.url="/SettlementPage"
        }
      }
      this.TotalMoney()
    },
    //全选
    allChecked() {
      //不为空
      if (event.target.checked) {
        this.arr = [];
        for (let index = 0; index < this.items.length; index++) {
          this.arr.push(index)
        }
        this.allCheck=true
        this.button=false
        this.url="/SettlementPage"
      }
      else {
        this.arr = [];
        this.allCheck=false
        this.button=true
        this.url="/AboutMe?selectedTag=2"
      }
      this.TotalMoney()
    },
    //单个商品总价
    ItemTotalMoney(index){
      let price=0;
      price=this.items[index].price*this.items[index].number
      this.items[index].total=price
    },
    //全部商品总价
    TotalMoney() {
      let allprice = 0
      for (let index = 0; index < this.arr.length; index++) {
        //allprice+=this.items[this.arr[index]].total * this.items[this.arr[index]].number
        allprice+=this.items[this.arr[index]].total
      }
      this.totalPrice = allprice

    },
    //结算时，获取购买商品的cart_id
    getCartId(){
      if(this.cart_id.length>0)
      {
        this.cart_id=[];
      }
      for(let index=0;index<this.arr.length;index++){
        this.cart_id.push(this.items[this.arr[index]]['id']);
      }
    },
    calculation(){
      if(this.button===false){
        this.getCartId()
        console.log(this.cart_id)
      }
    },
  },
  created() {
    this.getCartInfo()
    this.TotalMoney()
  },

  watch:{
    'arr.length': {
      handler(newValue, oldValue) {
        if (newValue !== oldValue) {
          this.TotalMoney()
          this.checked()
          this.calculation()
        }
      }
    },

  }
}
</script>

<style scoped>
.cart_nav{
  width: 1380px;
  height: 30px;
  margin: 0 auto;
}
.cart_nav input{
  margin-left: 16px;
  margin-top:11px;
}
.cart_item{
  width: 1380px;
  /*border: 1px black solid;*/
}
.el-card{
  height: 160px;
  width: 1380px;
  margin: 15px auto;
}
.goods_check {
  width: 40px;
  margin-top:60px;
  margin-right: -40px;
  float: left;
}
.goods_check input{
  margin-left: 10px;
}
.goods_img{
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
  width: 125px;
  float: left;
  margin-top: 20px;
  margin-left: 30px;
}
.el-input-number{
  width: 120px;
  size: auto;

}
.goods_total{
  height: 120px;
  width: 100px;

  float: left;
  margin-top: 20px;
  margin-left: 40px;
}
.goods_total p{

  display: block;

  font-size: 20px;
  font-family: "Microsoft YaHei";
  color: red;
}
.operation{
  height: 120px;
  width: 100px;

  float: left;
  margin-top: 20px;
  margin-left: 60px;
}
.cart_footer{
  height: 50px;


}

</style>