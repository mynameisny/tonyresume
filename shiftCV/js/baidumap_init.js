function baidumap_init(dom_obj, address, description, point) 
{
	var map = new BMap.Map("sc_baidumap");
	var point = new BMap.Point(116.478416,40.018244); //坐标不太好测量，尽量将目标放在屏幕右下角：http://api.map.baidu.com/lbsapi/creatmap/index.html
	map.centerAndZoom(point, 16);
	map.enableScrollWheelZoom();   //启用滚轮放大缩小，默认禁用
	map.enableContinuousZoom();    //启用地图惯性拖拽，默认禁用

	var top_left_control = new BMap.ScaleControl({anchor: BMAP_ANCHOR_TOP_LEFT});													// 左上角，添加比例尺
	var top_left_navigation = new BMap.NavigationControl();  																		//左上角，添加默认缩放平移控件
	var top_right_navigation = new BMap.NavigationControl({anchor: BMAP_ANCHOR_TOP_RIGHT, type: BMAP_NAVIGATION_CONTROL_SMALL}); 	//右上角，仅包含平移和缩放按钮
	map.addControl(top_left_control);        
	map.addControl(top_left_navigation);     
	//map.addControl(top_right_navigation);

	// 创建地址解析器实例
	var myGeo = new BMap.Geocoder();
	// 将地址解析结果显示在地图上,并调整地图视野
	myGeo.getPoint(address, function(point)
	{
		if (point) 
		{
			//map.centerAndZoom(point, 17);
			map.addOverlay(new BMap.Marker(point));
		}
	}, "北京市");
}