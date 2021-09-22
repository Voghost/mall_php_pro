<template>
  <div>
    <el-table
        :data="list_info.slice((currentPage-1)*pagesize,currentPage*pagesize)"
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
            <el-table-column align="center" label="操作" width="150">
              <template scope="scope">
                <el-button size="small" type="danger" @click="RequestRefund(scope.row)">申请退款
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
    <el-pagination
        @size-change="handleSizeChange"
        @current-change="handleCurrentChange"
        :current-page="currentPage"
        :page-sizes="[5, 10, 20, 40]"
        :page-size="pagesize"
        layout="total, sizes, prev, pager, next, jumper"
        :total="list_info.length">
    </el-pagination>
  </div>
</template>

<script>
export default {
  methods: {
    handleSizeChange: function (size) {
      this.pagesize = size;
      console.log(this.pagesize)  //每页下拉显示数据
    },
    handleCurrentChange: function (currentPage) {
      this.currentPage = currentPage;
      console.log(this.currentPage)  //点击第几页
    },
    RequestRefund(row){
      console.log(row)
    },
  },
  data() {
    return {
      currentPage: 1, //初始页
      pagesize: 10,    //    每页的数据
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
          goods_state: "配送中"
        }]
      },
        {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        },
        {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        },
        {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        },
        {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        },
        {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        },
        {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }, {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }, {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }, {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }, {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }, {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }, {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }, {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }, {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }, {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }, {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }, {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }, {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }, {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }, {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }, {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }, {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }, {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }, {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }, {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }, {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }, {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }, {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }, {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }, {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }, {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }, {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }, {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }, {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }, {
          names: 'S201841413227',
          date: '2016-05-03',
          all_prices: 2 * 123,
          goods: [{
            goods_image: '王小虎',
            goods_name: '你好',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
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
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "配送中"
          }]
        }],
    }
  }
}
</script>