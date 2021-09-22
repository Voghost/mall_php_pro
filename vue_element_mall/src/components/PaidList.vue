<template>
  <el-container>
  <el-table
      :data="list_info"
      style="width: 100%"
      default-expand-all>
<!--    :row-key="getRowKeys"-->
<!--    :expand-row-keys="expands"-->
    <el-table-column type="expand"> //type="expand" 带下层数据的字段
      <template scope="scope">
        <el-table class="demo-table-expand"
                  :data="scope.row.goods"
                  border
                  style="width: 100%">
          <el-table-column
              prop="goods.goods_image"
              label="商品照片"
              width="300"
          >
          </el-table-column>
          <el-table-column
              prop="goods_name"
              label="商品名字"
          >
          </el-table-column>
          <el-table-column
              prop="goods_price"
              label="商品单价"
              width="100"
          >
          </el-table-column>
          <el-table-column
              prop="goods_number"
              label="商品数量"
              width="100"
          >
          </el-table-column>
          <el-table-column
              prop="goods_prices"
              label="商品总价"
              width="100"
          >
          </el-table-column>
          <el-table-column
              prop="goods_state"
              width="100"
              label="状态">
          </el-table-column>
          <el-table-column align="center" label="操作" width="200">
            <template scope="scope">
              <el-button size="small" type="success" @click="logistics_info_dialog = true">物品物流
              </el-button>
              <el-button size="small" type="danger" @click="Request_refund(scope.row)">申请退款
              </el-button>
            </template>
          </el-table-column>
        </el-table>

      </template>
    </el-table-column>
    <el-table-column align="center"
                     label="订单编号"
                     prop="names">
    </el-table-column>
    <el-table-column align="center"
                     label="下单时间"
                     prop="date">
    </el-table-column>

  </el-table>
    <el-dialog
        title="物流消息"
        :visible.sync="logistics_info_dialog"
        width="30%">
      <Logistics_info_card style="padding: 50px"></Logistics_info_card>
    </el-dialog>
  </el-container>
</template>

<script>
import Logistics_info_card from "@/components/Logistics_info_card";
export default {
  components: {Logistics_info_card},
  methods:{
    Request_refund(row) {
      console.log(row)
    },
    goods_allprice(){
      let allprice=this.list_info.goods.goods_prices
      this.list_info.goods.forEach(function (index,array){
        const allprices=array[index].goods_number*array[index].goods_price
        allprice=allprice+allprices;
      })
      this.list_info.all_prices=allprice
    },
  },
  data() {
    return {
      logistics_info_dialog: false,
      list_info: [{
        names: 'S201841413227',
        date: '2016-05-03',
        all_prices:0,
        goods: [{
          goods_image: '王小虎',
          goods_name: '你好',
          goods_price: 123,
          goods_number: 2,
          goods_prices: 0,
          goods_state: "配送中"
        }]
      },
        {
          names: 'S12456742194',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '20飞机杯一号',
            goods_price: 123,
            goods_number: 3,
            goods_prices: 0,
            goods_state: "配送中"
          },
            {
              goods_image: '冯炳超',
              goods_name: '冯炳超飞机杯二号',
              goods_price: 123,
              goods_number: 2,
              goods_prices: 2 * 123,
              goods_state: "配送中"
            }]
        }],
    }
  }
}
</script>