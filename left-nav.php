<div class="sidebar" data-color="purple" data-image="assets/img/sidebar-5.jpg">
	    <div class="sidebar-wrapper">
            <div class="logo">
                <a href="#" class="simple-text" id="navYear">
                    Item WareHouse
                </a>
            </div>

            <ul class="nav" id="leftNav">
                <li>
                    <a idef="itemwarehouse" href="itemwarehouse.php">
                        <i class="pe-7s-graph"></i>
                        <p>Items</p>
                    </a>
                </li>
                <li>
                    <a idef="customer" href="customer.php">
                        <i class="pe-7s-news-paper"></i>
                        <p>Customer</p>
                    </a>
                </li>
				<li>
                    <a idef="sales" href="sales.php">
                        <i class="pe-7s-news-paper"></i>
                        <p>Sales Billing</p>
                    </a>
                </li>
				<li>
                    <a idef="purchase" href="purchase.php">
                        <i class="pe-7s-news-paper"></i>
                        <p>Purchase Billing</p>
                    </a>
                </li>
				<li>
                    <a idef="itemhistory" href="itemhistory.php">
                        <i class="pe-7s-news-paper"></i>
                        <p>item history</p>
                    </a>
                </li>
				<li>
                    <a idef="portfolio" href="portfolio.php">
                        <i class="pe-7s-news-paper"></i>
                        <p>Portfolio performance </p>
                    </a>
                </li>
			</ul>
			
	</div>
	<!-- Modal -->
	<script type="text/javascript">
		$( window ).load(function() {
	
	var x=window.location.pathname.substring(1);
	var end=x.indexOf(".php")
	var start=x.indexOf("/")
	var selected=x.substring(start+1,end)
	MarkActive();
	function MarkActive()
	{
		$('#leftNav li').each(function(){
			console.log("hi");
			if($(this).find('a').attr('idef').trim().toUpperCase().trim().indexOf(selected.toUpperCase())!=-1)
			{
				$(this).addClass('active')
			}
		})
	}
	
});
    	$(document).ready(function(){
			
    	});
		
	</script>
</div> 