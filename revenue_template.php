<?php
/*
Template Name: Revenue Page Template
* This is to be used for the one instance page showing revenue
* 
*/
?>

<?php get_header(); ?>
 <div id="maincontainer" class="overview" >
   <h3>Description</h3>
   <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

   					<?php if ( is_front_page() ) { ?>
   						<!-- ><h2><?php the_title(); ?></h2> -->
   					<?php } else { ?>	
   					<!--	<h1><?php the_title(); ?></h1> -->
   					<?php } ?>				

   						<?php the_content(); ?>
  <h3>Quick Stats</h3>
    <div id="stats"></div>
  <h3>Revenue Received</h3>
    <p>Chart coming soon.</p>
	  <div id="holder"></div>

  <h3>Economic Development Monthly Revenue</h3>
    <p>Something about fiscal years starting on July 1 and what budgeted and actual mean.</p> 
    <div id="monthly"><img class="spinner" src="/wp-content/themes/wp-splost/fbi_spinner.gif"></div>

  <div id="sharing">
    <p>Share this page: </p>
    <a href="https://twitter.com/share" class="twitter-share-button" data-via="MayorReichert" data-hashtags="MaconSPLOST">Tweet</a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];
      if(!d.getElementById(id)){js=d.createElement(s);
      js.id=id; js.src="//platform.twitter.com/widgets.js";
      fjs.parentNode.insertBefore(js,fjs);}
      }(document,"script","twitter-wjs");</script>
    <g:plusone size="medium"></g:plusone>
    <div class="fb-like" data-send="true" data-layout="button_count" data-width="100" data-show-faces="false"></div>
  </div>
  <!--nextpage-->
  <div id="post-nav">
    <span class="prevPageNav">
      <?php 
      echo previous_page_not_post('', true, ''); ?> 
    </span>  
    <span class="nextPageNav" >
      <?php 
      echo next_page_not_post('', true, '' );  ?> 
    </span>
  </div>

  <span class="button wpedit">
    <?php edit_post_link( __( 'Edit', 'twentyten' ), '', '' ); ?></span>
    <?php comments_template( '', true ); ?>

   <?php endwhile; ?>
</div><!-- end #maincontainer -->
    
    

    
<script id="monthly" type="text/html">
  <h6 class="fleft">Monthly Report for:</h6> 
  <p><span class="statHighlight">  {{reportmonth}} / {{reportyear}}</span></p>
  <table class="monthlytable">
  <thead>
  <tr class="tableheader">
  <th>PROJECT</th><th>STATUS</th><th>BUDGET</th><th>Actual</th>
  </tr>
  </thead>
  {{#rows}}
    <tr>
    <td>{{project}}</td><td >{{status}}</td><td class="tright yrdolls">{{budget}}</td><td class="tright yrdolls">{{ptdactual}}</td></tr>
  {{/rows}}
  </table>
</script>
    
<script id="stats" type="text/html">
 <h5>Total Budgeted Revenue: <span class="statHighlight">{{totalBudgeted}}</span> vs Total Actual Revenue: <span class="statHighlight">{{totalActual}}</span></h5>
</script>

    
    <script type="text/javascript">    
      document.addEventListener('DOMContentLoaded', function() {
         loadSpreadsheet(showInfo)
       })    

       function showInfo(data, tabletop) {
               
               
         accounting.settings.currency.precision = 0
         var pageParent = "<?php echo get_the_title($post->post_parent) ?>"
         var pageName = "<?php the_title(); ?>"
         var thePageParent = getType(data, pageParent)
         var thePageName  = getProject(data, pageName)
         

      //    function pushBits(element) {
      //       values.push(parseInt(element.total))
      //       labels.push(element.project)
      //       hexcolors.push(element.hexcolor)
      //     }
              
      //     var r = Raphael("holder")
      //     var values = []
      //     var labels = []
      //     var hexcolors = []
      //         thePageParent.forEach(pushBits)

      // // (paper, x, y, width, height, values, opts)
      // r.g.hbarchart(170, 15, 480, 90, values, {stacked: true, type: "soft", colors: hexcolors, gutter: "20%"}).hoverColumn(
      //   function() { 
      //     var y = []
      //     var res = []

      //         for (var i = this.bars.length; i--;) {
      //             y.push(this.bars[i].y);
      //             res.push(this.bars[i].value || "0");
      //         }
      //         this.flag = r.g.popup(this.bars[0].x, Math.min.apply(Math, y), res.join(", ")).insertBefore(this);
      // }, function() {
      //       this.flag.animate({opacity: 0}, 1500, ">", function () {this.remove();});
      // });
      // // (x, y, length, from, to, steps, orientation, labels, type, dashsize, paper)
      // axis = r.g.axis(160,80,45,null, null,1,1, labels.reverse(), null, 1);
      // axis.text.attr({font:"12px Arvo", "font-weight": "regular", "fill": "#333333"}); 
          

      var monthlyrev = getActualsArea(tabletop.sheets("actuals").all(), pageName)
      var totalBudgeted = getTotalBudget(monthlyrev)
      var totalActual = getTotalActual(monthlyrev)
      var reportmonth = getCurrentMonth() - 1
      var reportyear = getCurrentYear()

      var theDiff = getDiff(totalBudgeted, totalActual)
      console.log(accounting.formatMoney(theDiff))
      //These populate the page's tables 

      var monthly = ich.monthly({
        "rows": turnReportCurrency(monthlyrev),
        "reportyear": reportyear,
        "reportmonth": reportmonth
      })

      var stats = ich.stats({
        "totalBudgeted": accounting.formatMoney(totalBudgeted),
        "totalActual": accounting.formatMoney(totalActual)
      })

         document.getElementById('monthly').innerHTML = monthly; 
         document.getElementById('stats').innerHTML = stats; 

       }
    </script>



<?php get_sidebar(); ?>
<?php get_footer(); ?>