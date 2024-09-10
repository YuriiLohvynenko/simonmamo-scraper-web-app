<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link href="/r/favicon.ico" rel="icon">
	<meta content="width=device-width,initial-scale=1" name="viewport">
	<meta content="#000000" name="theme-color">

	<title>_</title>
    <!-- <link href="http://hotelbooking.group/public/main.6ac71a96.chunk.css" rel="stylesheet"> -->
	<link href="./main.6ac71a96.chunk.css" rel="stylesheet">
    <link href="../main.6ac71a96.chunk.css" rel="stylesheet">
	<style id="_goober">
	   .go626121005 input,.go626121005 span{vertical-align:middle;margin:0;}.go626121005 span{display:inline-block;padding-left:5px;}.go626121005.disabled{opacity:0.5;}.go3973839879{box-sizing:border-box;cursor:pointer;display:block;padding:var(--rmsc-p);outline:0;}.go3973839879:hover,.go3973839879:focus{background:var(--rmsc-hover);}.go3973839879.selected{background:var(--rmsc-selected);}.go2343601875{margin:0;padding-left:0;}.go2343601875 li{list-style:none;margin:0;}.go1075022653{width:100%;position:relative;border-bottom:1px solid var(--rmsc-border);}.go1075022653 input{height:var(--rmsc-h);padding:0 var(--rmsc-p);width:100%;outline:0;border:0;}.go3703752690{cursor:pointer;position:absolute;top:0;right:0;bottom:0;background:none;border:0;padding:0 calc(var(--rmsc-p)/2);}.go3703752690 [hidden]{display:none;}.go1405233898{animation:rotate 2s linear infinite;}.go1405233898 .path{stroke:var(--rmsc-border);stroke-width:4px;stroke-linecap:round;animation:dash 1.5s ease-in-out infinite;}@keyframes rotate{100%{transform:rotate(360deg);}}@keyframes dash{0%{stroke-dasharray:1,150;stroke-dashoffset:0;}50%{stroke-dasharray:90,150;stroke-dashoffset:-35;}100%{stroke-dasharray:90,150;stroke-dashoffset:-124;}}.go3425554998{position:absolute;z-index:1;top:100%;width:100%;padding-top:8px;}.go3425554998 .panel-content{max-height:300px;overflow-y:auto;border-radius:var(--rmsc-radius);background:var(--rmsc-bg);box-shadow:0 0 0 1px rgba(0, 0, 0, 0.1), 0 4px 11px rgba(0, 0, 0, 0.1);}.go2646822163{position:relative;outline:0;background-color:var(--rmsc-bg);border:1px solid var(--rmsc-border);border-radius:var(--rmsc-radius);}.go2646822163:focus-within{box-shadow:var(--rmsc-main) 0 0 0 1px;border-color:var(--rmsc-main);}.go2642161244{position:relative;padding:0 var(--rmsc-p);display:flex;align-items:center;width:100%;height:var(--rmsc-h);cursor:default;outline:0;}.go2642161244 .dropdown-heading-value{overflow:hidden;text-overflow:ellipsis;white-space:nowrap;flex:1;}.go367124755{cursor:pointer;background:none;border:0;padding:0;}.go2139093995{--rmsc-main:#4285f4;--rmsc-hover:#f1f3f5;--rmsc-selected:#e2e6ea;--rmsc-border:#ccc;--rmsc-gray:#aaa;--rmsc-bg:#fff;--rmsc-p:10px;--rmsc-radius:4px;--rmsc-h:38px;}.go2139093995 *{box-sizing:border-box;transition:all 0.2s ease;}.go2139093995 .gray{color:var(--rmsc-gray);}
    </style>
    <style>
        table, th, td {
        border: 1px solid black;
        cellspacing:0px;
        cellpadding:0px;
        padding:5px;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <style type="text/css">
        .dropdown-toggle {
            height: 40px;
            /* width: 200px !important; */
        }
    </style>
</head>
<body>
    <?php
        $pagecounts = $listing_count[0]->listing_count / 20;
        if ($listing_count[0]->listing_count % 20 != 0){
            $pagecounts = intdiv($listing_count[0]->listing_count, 20) + 1;
        }
        function real_value($value) {
            $return_value = str_replace("@@@", "'", $value);
            $return_value = str_replace("###", '"', $return_value);
            return $return_value;
        }
    ?>
	<div id="root">
		<div>
			<div class="header">
				<span class="reports"><a href="/listing">Listings</a></span>
			</div>
            
			<div id="filter-cont">
                <form action="/search" method="GET" id="searchform">
				<div class="filter">
                    <div class="filter-card">
                        <p>Item ID</p><input id="item_id" placeholder="-" type="text" value="@if(isset($request->item_id)){{$request->item_id}}@endif" name="item_id">
                    </div>
					<div class="filter-card">
						<p>Listing type</p><select id="sel-owner" class="selectpicker" multiple data-live-search="true" name="listing_type[]">
                            @if(isset($request->listing_type))
                                <option value="Rental"
                                @foreach ($request->listing_type as $con_listing_type)
                                @if($con_listing_type=="Rental")
                                selected
                                @endif
                                @endforeach
                                >
                                    Rentals
                                </option>
                                <option value="Sales"
                                @foreach ($request->listing_type as $con_listing_type)
                                @if($con_listing_type=="Sales")
                                selected
                                @endif
                                @endforeach
                                >
                                    Sales
                                </option>
                            @else
                                <option value="Rental">
                                    Rentals
                                </option>
                                <option value="Sales">
                                    Sales
                                </option>
                            @endif
                            
                            
						</select>
					</div>
					<div class="filter-card">
						<p>Category</p><select id="sel-owner" class="selectpicker" multiple data-live-search="true" name="category[]">
                        @if(isset($request->category))
                            
                            @foreach ($real_cate as $category)
                                <option value="{{$category}}"
                                @foreach ($request->category as $con_category)
                                @if($con_category==$category)
                                selected
                                @endif
                                @endforeach
                                >
                                {{$category}}
                                    
                                </option>
                            @endforeach
                        @else
                            @foreach ($real_cate as $category)
                                <option value="{{$category}}">
                                {{$category}}
                                    
                                </option>
                            @endforeach
                        @endif
						</select>
					</div>
					<div class="filter-card">
						<p>Commercial</p>
						<select id="sel-owner" class="selectpicker" multiple data-live-search="true" name="commercial[]">
                            @if(isset($request->commercial))
                                <option value=""
                                @foreach ($request->commercial as $con_commercial)
                                @if($con_commercial=="")
                                selected
                                @endif
                                @endforeach
                                >
                                    No
                                </option>
                                <option value="1"
                                @foreach ($request->commercial as $con_commercial)
                                @if($con_commercial=="1")
                                selected
                                @endif
                                @endforeach
                                >
                                    Yes
                                </option>
                            @else
                                <option value="">
                                    No
                                </option>
                                <option value="1">
                                    Yes
                                </option>
                            @endif
						</select>
                    </div>
                    <div class="filter-card">
						<p>Location</p><input id="location" placeholder="location" type="text" value="@if(isset($request->location)){{$request->location}}@endif" name="location">
                    </div>
                    <div class="filter-card">
						<p>Sale price from (€)</p><input id="minsaleprice" placeholder="No limit" type="text" value="@if(isset($request->minsaleprice)){{$request->minsaleprice}}@endif" name="minsaleprice">
                    </div>
                    <div class="filter-card">
						<p>Sale price to (€)</p><input id="maxsaleprice" placeholder="No limit" type="text" value="@if(isset($request->maxsaleprice)){{$request->maxsaleprice}}@endif" name="maxsaleprice">
                    </div>
                    <div class="filter-card">
						<p>Rental price from (€)</p><input id="minrentalprice" placeholder="No limit" type="text" value="@if(isset($request->minrentalprice)){{$request->minrentalprice}}@endif" name="minrentalprice">
                    </div>
                    <div class="filter-card">
						<p>Rental price to (€)</p><input id="maxrentalprice" placeholder="No limit" type="text" value="@if(isset($request->maxrentalprice)){{$request->maxrentalprice}}@endif" name="maxrentalprice">
                    </div>
                    <div class="filter-card">
						<p>Bedrooms</p>
                        <select class="selectpicker" multiple data-live-search="true" name="bedrooms[]">
                            @if(isset($request->bedrooms))
                                @for ($i = 0; $i < 16; $i++)
                                    <option value="{{$i}}"
                                    @foreach ($request->bedrooms as $bedroom)
                                    @if($bedroom==$i)
                                    selected
                                    @endif
                                    @endforeach
                                    >
                                        {{$i}}
                                    </option>
                                @endfor
                            @else
                                @for ($i = 0; $i < 16; $i++)
                                    <option value="{{$i}}">
                                        {{$i}}
                                    </option>
                                @endfor
                            @endif
						</select>
                    </div>
                    <div class="filter-card">
						<p>Owner ID</p><input id="ownerid" placeholder="-" type="text" value="@if(isset($request->ownerid)){{$request->ownerid}}@endif" name="ownerid">
                    </div>
                    <div class="filter-card">
						<p>Owner name</p><input id="ownername" placeholder="-" type="text" value="@if(isset($request->ownername)){{$request->ownername}}@endif" name="ownername">
                    </div>
                    <div class="filter-card">
						<p>Mobile</p><input id="mobile" placeholder="-" type="text" value="@if(isset($request->mobile)){{$request->mobile}}@endif" name="mobile">
					</div>
                    <div class="filter-card">
						<p>Must-Have</p>
                        <select class="selectpicker" multiple data-live-search="true" name="labels[]">
                            @if(isset($request->labels))
                                <option value="ownername"
                                @foreach ($request->labels as $label)
                                @if($label=='ownername')
                                selected
                                @endif
                                @endforeach
                                >
                                Owner name
                                </option>
                                <option value="mobile"
                                @foreach ($request->labels as $label)
                                @if($label=='mobile')
                                selected
                                @endif
                                @endforeach
                                >
                                Mobile
                                </option>
                            @else
                                <option value="ownername">Owner name</option>
                                <option value="mobile">Mobile</option>
                            @endif
						</select>
                    </div>
					<div class="filter-card">
						<p>Sort by</p><select class="sel-owner" name="modifieddate">
                        @if(isset($request->modifieddate))
                            @if ($request->modifieddate == "ASC")
							<option value="ASC" selected>
                                Date modified ASC
							</option>
							<option value="DESC">
                                Date modified DESC
							</option>
                            @elseif ($request->modifieddate == "DESC")
                            <option value="ASC">
                                Date modified ASC
							</option>
							<option value="DESC" selected>
                                Date modified DESC
							</option>
                            @endif
                        @else
                            <option value="ASC">
                                Date modified ASC
							</option>
							<option value="DESC" selected>
                                Date modified DESC
							</option>
                        @endif
						</select>
					</div>
					<div class="filter-card">
						
                        <button type="submit" class="btn-filter">
							SEARCH
                        </button>
						
					</div>
				</div>

                

                </form>
			</div>

            <div class="mm_pagination">
                <h5 id="res-count">Results: {{$listing_count[0]->listing_count}} </h5>
                <span class="p-current">Page {{$currentpage}}/{{$pagecounts}}</span>
                @if(isset($request))
                    @if($currentpage > 1)
                    <a class="p-next" href="/search/1?{{$formdata}}">FIRST</a>
                    <a class="p-next" href="/search/{{$currentpage-1}}?{{$formdata}}">PREV</a>
                    @endif
                    @if($currentpage < $pagecounts)
                    <a class="p-next" href="/search/{{$currentpage+1}}?{{$formdata}}" type="submit">NEXT</a>
                    <a class="p-last" href="/search/{{$pagecounts}}?{{$formdata}}">LAST</a>
                    @endif
                @else
                    @if($currentpage > 1)
                    <a class="p-next" href="/listing/1">FIRST</a>
                    <a class="p-next" href="/listing/{{$currentpage-1}}">PREV</a>
                    @endif
                    @if($currentpage < $pagecounts)
                    <a class="p-next" href="/listing/{{$currentpage+1}}">NEXT</a>
                    <a class="p-last" href="/listing/{{$pagecounts}}">LAST</a>
                    @endif
                @endif
            </div>
			
			<table>
				<tbody>
                    @foreach ($listings as $listing)
                    <tr>
                        <td width='33%'>
                            <b>Property info:</b>
                            <table style="border:1px;">
                                <tr>
                                    <td colspan="2"><b>URL: </b> <input type="text" value="{{real_value($listing->url)}}" size="80%"> </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>ID:</b> {{$listing->item_id}}
                                    </td>
                                    <td>
                                        <b>Date modified:</b> {{gmdate("Y-m-d\TH:i:s\Z", intval($listing->modified_date))}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Type:</b> {{real_value($listing->category)}}
                                    </td>
                                    <td>
                                        <b>Address:</b> {{real_value($listing->address)}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Rent price:</b> {{$listing->rent_price}}
                                    </td>
                                    <td>
                                        <b>Sale price:</b> {{$listing->sale_price}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Bedrooms:</b> {{$listing->bedrooms}}
                                    </td>
                                    <td>
                                        <b>Bathrooms:</b> {{$listing->bathrooms}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Area:</b> 
                                    </td>
                                    <td>
                                        {{real_value($listing->area)}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width='33%'>
                            <b>Owner info:</b>
                            <table style="border:1px;">
                                <tr>
                                    <td width="50%">
                                        <b>Owner ID:</b> {{$listing->owner_id}}
                                    </td>
                                    <td>
                                        <b>Name:</b> {{real_value($listing->ownername)}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Mobile:</b> 
                                    </td>
                                    <td>
                                        {{real_value($listing->mobile)}}
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <b>Other:</b>
                            <table style="border:1px;">
                                <tr>
                                    <td colspan="2"><b>Notes:</b> {{real_value($listing->notes)}}</td>
                                </tr>
                                <tr>
                                    <td width="50%">
                                        <b>Directions:</b> 
                                    </td>
                                    <td>
                                        {{real_value($listing->directions)}}
                                    </td>
                                </tr>
                            </table>
                            
                        </td>
                        <td>
                            <b>{{real_value($listing->title)}}</b>
                            <p>{{real_value($listing->description)}}</p>
                        </td>
                    </tr>
                    @endforeach
				</tbody>
			</table>
			<div class="mm_pagination">
                <h5 id="res-count">Results: {{$listing_count[0]->listing_count}} </h5>
                <span class="p-current">Page {{$currentpage}}/{{$pagecounts}}</span>
                @if(isset($request))
                    @if($currentpage > 1)
                    <a class="p-next" href="/search/1?{{$formdata}}">FIRST</a>
                    <a class="p-next" href="/search/{{$currentpage-1}}?{{$formdata}}">PREV</a>
                    @endif
                    @if($currentpage < $pagecounts)
                    <a class="p-next" href="/search/{{$currentpage+1}}?{{$formdata}}" type="submit">NEXT</a>
                    <a class="p-last" href="/search/{{$pagecounts}}?{{$formdata}}">LAST</a>
                    @endif
                @else
                    @if($currentpage > 1)
                    <a class="p-next" href="/listing/1">FIRST</a>
                    <a class="p-next" href="/listing/{{$currentpage-1}}">PREV</a>
                    @endif
                    @if($currentpage < $pagecounts)
                    <a class="p-next" href="/listing/{{$currentpage+1}}">NEXT</a>
                    <a class="p-last" href="/listing/{{$pagecounts}}">LAST</a>
                    @endif
                @endif
            </div>
		</div>
	</div>


</body>
<script type="text/javascript">
    $(document).ready(function() {
        $('select').selectpicker();
    });
</script>
</html>