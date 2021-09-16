<template>
  <el-table
      :data="list_info"
      :row-key="getRowKeys"
      :expand-row-keys="expands"
      style="width: 100%"
      default-expand-all>
    <el-table-column type="expand"> //type="expand" 带下层数据的字段
      <template scope="scope">
        <el-table class="demo-table-expand"
                  :data="scope.row.goods"
                  border
                  style="width: 100%">
          <el-table-column
              prop="goods.goods_image"
              label="商品照片"
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
    <el-table-column align="center"
                     label="订单支付"
                     prop="all_prices">
    </el-table-column>
  </el-table>
</template>

<script>
export default {
  data() {
    return {
      dialogVisible: false,
      list_info: [{
        names: 'S201841413227',
        date: '2016-05-03',
        all_prices: 2 * 123,
        goods: [{
          goods_image: '王小虎',
          goods_name: '你好',
          goods_price: 123,
          goods_number: 2,
          goods_prices: 2 * 123,
          goods_state: "申请退款中"
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
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "申请退款中"
          }]
        }],
    }
  }
}
</script>