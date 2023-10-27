//Pseudo code
//Step 1: Define chart properties.
//Step 2: Create the chart with defined properties and bind it to the DOM element.
//Step 3: Add the CandleStick Series.
//Step 4: Set the data and render.
//Step5 : Plug the socket to the chart


//Code
function display_chart(info, id="tvchart") {
  const log = console.log;

const chartProperties = {
  // width:200,
  height:300,
  timeScale:{
    timeVisible:true,
    secondsVisible:true,

  }
}

const domElement = document.getElementById(id);
const chart = LightweightCharts.createChart(domElement,chartProperties);
const candleSeries = chart.addCandlestickSeries();
const data = JSON.parse(info);
// const data = [[1693719000000,"0.50230000","0.50410000","0.50230000","0.50400000","1251462.00000000",1693719059999,"629926.73440000",602,"1058814.00000000","532961.06580000","0"],[1693719060000,"0.50400000","0.50470000","0.50370000","0.50380000","332297.00000000",1693719119999,"167566.30510000",337,"140707.00000000","70953.22400000","0"],[1693719120000,"0.50380000","0.50390000","0.50340000","0.50360000","157681.00000000",1693719179999,"79406.11980000",84,"86973.00000000","43791.58500000","0"],[1693719180000,"0.50370000","0.50460000","0.50370000","0.50450000","462930.00000000",1693719239999,"233462.35630000",150,"395931.00000000","199682.79930000","0"],[1693719240000,"0.50450000","0.50550000","0.50450000","0.50490000","821305.00000000",1693719299999,"414783.31670000",387,"470143.00000000","237413.51900000","0"],[1693719300000,"0.50490000","0.50500000","0.50420000","0.50420000","214037.00000000",1693719359999,"107970.92400000",122,"131233.00000000","66211.18640000","0"],[1693719360000,"0.50430000","0.50430000","0.50390000","0.50390000","74508.00000000",1693719419999,"37560.99980000",62,"28062.00000000","14145.00560000","0"],[1693719420000,"0.50390000","0.50430000","0.50390000","0.50430000","82658.00000000",1693719479999,"41668.12690000",49,"75179.00000000","37898.39260000","0"],[1693719480000,"0.50420000","0.50430000","0.50400000","0.50400000","147415.00000000",1693719539999,"74321.11500000",40,"550.00000000","277.31970000","0"],[1693719540000,"0.50400000","0.50440000","0.50400000","0.50440000","78466.00000000",1693719599999,"39557.18670000",49,"73584.00000000","37096.54260000","0"],[1693719600000,"0.50440000","0.50440000","0.50360000","0.50360000","132548.00000000",1693719659999,"66819.34270000",79,"12562.00000000","6331.00920000","0"]];

// fetch(`https://api.binance.com/api/v3/klines?symbol=ETHUSDT&interval=1d&limit=1000`)
//   .then(res => res.json())
//   .then(data => {
    const cdata = data.map(d => {
      return {time:d[0]/1000,open:parseFloat(d[1]),high:parseFloat(d[2]),low:parseFloat(d[3]),close:parseFloat(d[4])}
    });
    candleSeries.setData(cdata);
}
  // })
  // .catch(err => log(err))

//Dynamic Chart
// const socket = io.connect('http://127.0.0.1:4000/');

// socket.on('KLINE',(pl)=>{
//   //log(pl);
//   candleSeries.update(pl);
// });