/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Ecommerce product list Js File
*/




// Beef ثم pasta ثم Pizza بترتيب coll انا كده بعمل 
var productListAllData=[];
var productListAll;
var productListPublished;
var langData={};
async function getLanguage() {
	var language='ar';//;document.documentElement.lang
	language == null ? setLanguage(document.documentElement.lang) : false;
	var request = new XMLHttpRequest();
	// Instantiating the request object
	request.open("GET", "/assets/lang/" + language + ".json");
	// Defining event listener for readystatechange event
	request.onreadystatechange = function () {
		// Check if the request is compete and was successful
		if (this.readyState === 4 && this.status === 200) {
			langData = JSON.parse(this.responseText);				
		}
	};
	// Sending the request to the server
	request.send();
}

async function getData() {
	await getAllData();
	await getLanguage();
};
getData();

async function getAllData() {
	await listDataInTable(document.getElementById("table-product-list-all"));

};

async function listData(productListAllData)
{

	var inputValueJson = sessionStorage.getItem('inputValue');
	if (inputValueJson) {
		inputValueJson = JSON.parse(inputValueJson);
		Array.from(inputValueJson).forEach(element => {
			productListAllData.unshift(element);
		});
	}

	var editinputValueJson = sessionStorage.getItem('editInputValue');
	if(editinputValueJson){
		editinputValueJson = JSON.parse(editinputValueJson);
		productListAllData = productListAllData.map(function (item) {
			if (item.id == editinputValueJson.id) {
				return editinputValueJson;
			}
			return item;
		});
	}
	document.getElementById("addproduct-btn").addEventListener("click", function(){
		sessionStorage.setItem('editInputValue',"")
	})
	listDataInTable(document.getElementById("table-product-list-all"));
	
	 // productListAll = listDataInTable(productListAllData,document.getElementById("table-product-list-all"));

	// table-product-list-published
	var productListPublishedData =[]

	// productListPublished = listDataInTable(productListPublishedData,document.getElementById("table-product-list-published"));


	// Search product list
	var searchProductList = document.getElementById("searchProductList");
	searchProductList.addEventListener("keyup", function () {
		var inputVal = searchProductList.value.toLowerCase();
		function filterItems(arr, query) {
			return arr.filter(function (el) {
				return el.product.name.toLowerCase().indexOf(query.toLowerCase()) !== -1
			})
		}

		var filterData = filterItems(productListAllData, inputVal);
		//var filterPublishData = filterItems(productListPublishedData, inputVal);
		productListAll.updateConfig({
			data: filterData
		}).forceRender();

		// productListPublished.updateConfig({
		// 	data: filterPublishData
		// }).forceRender();
		checkRemoveItem();
	});

	// mail list click event
	Array.from(document.querySelectorAll('.filter-list a')).forEach(function (filteritem) {
		filteritem.addEventListener("click", function () {
			var filterListItem = document.querySelector(".filter-list a.active");
			if (filterListItem) filterListItem.classList.remove("active");
			filteritem.classList.add('active');

			var filterItemValue = filteritem.querySelector(".listname").innerHTML

			var filterData = productListAllData.filter(filterlist => filterlist.product.category === filterItemValue);
			var filterPublishedData = productListPublishedData.filter(filterlist => filterlist.product.category === filterItemValue);

			productListAll.updateConfig({
				data: filterData
			}).forceRender();

			// productListPublished.updateConfig({
			// 	data: filterPublishedData
			// }).forceRender();

			checkRemoveItem();
		});
	})

	// price range slider
	var slider = document.getElementById('product-price-range');

	noUiSlider.create(slider, {
		start: [0, 2000], // Handle start position
		step: 10, // Slider moves in increments of '10'
		margin: 20, // Handles must be more than '20' apart
		connect: true, // Display a colored bar between the handles
		behaviour: 'tap-drag', // Move handle on tap, bar is draggable
		range: { // Slider can select '0' to '100'
			'min': 0,
			'max': 2000
		},
		format: wNumb({ decimals: 0, prefix: langData.sar })
	});

	var minCostInput = document.getElementById('minCost'),
		maxCostInput = document.getElementById('maxCost');

	var filterDataAll = '';
	var filterDataPublished = '';

	// When the slider value changes, update the input and span
	slider.noUiSlider.on('update', function (values, handle) {
		var productListupdatedAll = productListAllData;
		var productListupdatedPublished = productListPublishedData;
		if (handle) {
			maxCostInput.value = values[handle];

		} else {
			minCostInput.value = values[handle];
		}

		var maxvalue = maxCostInput.value.substr(2);
		var minvalue = minCostInput.value.substr(2);
		filterDataAll = productListupdatedAll.filter(
			product => parseFloat(product.price) >= minvalue && parseFloat(product.price) <= maxvalue
		);
		filterDataPublished = productListupdatedPublished.filter(
			product => parseFloat(product.price) >= minvalue && parseFloat(product.price) <= maxvalue
		);
		productListAll.updateConfig({
			data: filterDataAll
		}).forceRender();
		// productListPublished.updateConfig({
		// 	data: filterDataPublished
		// }).forceRender();
		checkRemoveItem();
	});


	minCostInput.addEventListener('change', function () {
		slider.noUiSlider.set([null, this.value]);
	});

	maxCostInput.addEventListener('change', function () {
		slider.noUiSlider.set([null, this.value]);
	});

	// text inputs example
	// var filterChoicesInput = new Choices(
	// 	document.getElementById('filter-choices-input'),
	// 	{
	// 		addItems: true,
	// 		delimiter: ',',
	// 		editItems: true,
	// 		maxItemCount: 10,
	// 		removeItems: true,
	// 		removeItemButton: true,
	// 	}
	// )


		// sidebar filter check
		Array.from(document.querySelectorAll(".filter-accordion .accordion-item")).forEach(function (item) {
			var isFilterSelected = item.querySelectorAll(".filter-check .form-check .form-check-input:checked").length;
			item.querySelector(".filter-badge").innerHTML = isFilterSelected;
			Array.from(item.querySelectorAll(".form-check .form-check-input")).forEach(function (subitem) {
				var checkElm = subitem.value;
				if (subitem.checked) {
					filterChoicesInput.setValue([checkElm]);
				}
				subitem.addEventListener("click", function (event) {
					if (subitem.checked) {
						isFilterSelected++;
						item.querySelector(".filter-badge").innerHTML = isFilterSelected;
						(isFilterSelected > 0) ? item.querySelector(".filter-badge").style.display = 'block' : item.querySelector(".filter-badge").style.display = 'none';
						filterChoicesInput.setValue([checkElm]);

					} else {
						filterChoicesInput.removeActiveItemsByValue(checkElm);
					}
				});
				filterChoicesInput.passedElement.element.addEventListener('removeItem', function (event) {
					if (event.detail.value == checkElm) {
						subitem.checked = false;
						isFilterSelected--;
						item.querySelector(".filter-badge").innerHTML = isFilterSelected;
						(isFilterSelected > 0) ? item.querySelector(".filter-badge").style.display = 'block' : item.querySelector(".filter-badge").style.display = 'none';
					}
				}, false);
				// clearall
				document.getElementById("clearall").addEventListener("click", function () {
					subitem.checked = false;
					filterChoicesInput.removeActiveItemsByValue(checkElm);
					isFilterSelected = 0;
					item.querySelector(".filter-badge").innerHTML = isFilterSelected;
					(isFilterSelected > 0) ? item.querySelector(".filter-badge").style.display = 'block' : item.querySelector(".filter-badge").style.display = 'none';
					productListAll.updateConfig({
						data: productListAllData
					}).forceRender();

					// productListPublished.updateConfig({
					// 	data: productListPublishedData
					// }).forceRender();
				});
			});
		});


	// Search Brands Options
	// var searchBrandsOptions = document.getElementById("searchBrandsList");
	// searchBrandsOptions.addEventListener("keyup", function () {
	// 	var inputVal = searchBrandsOptions.value.toLowerCase();
	// 	var searchItem = document.querySelectorAll("#flush-collapseBrands .form-check");
	// 	Array.from(searchItem).forEach(function (elem) {
	// 		var searchBrandsTxt = elem.getElementsByClassName("form-check-label")[0].innerText.toLowerCase();
	// 		elem.style.display = searchBrandsTxt.includes(inputVal) ? "block" : "none";
	// 	})
	// });
}


function listDataInTable(table)
{
		let minCost=$('#minCost').val()
		let maxCost=$('#maxCost').val()
		productListAll = new gridjs.Grid({
			columns: [ 'المنتج','الكمية','السعر','الطلبات',
				'التقييم','تاريخ اﻹنشاء','اﻹجراءات'],
			server: {
			    url: '/vendor/products-for-table?min='+minCost+'&max='+maxCost,
			    then: data => data.data.map(row => [
				    	// gridjs.html(`<div class="form-check checkbox-product-list">\
			 			// 	<input class="form-check-input" type="checkbox" value="${row.id}" id="checkbox-${row.id}" onchange="document.getElementById('selection-element').style.display='block' ">\
			 			// 	<label class="form-check-label" for="checkbox-${row.id}"></label>
						//   </div>`),
				    	gridjs.html('<div class="d-flex align-items-center">' +
								'<div class="flex-shrink-0 me-3">' +
								'<div class="avatar-sm bg-light rounded p-1"><img src="' + row.product.image + '" alt="" class="img-fluid d-block"></div>' +
								'</div>' +
								'<div class="flex-grow-1">' +
								'<h5 class="fs-14 mb-1"><a href="apps-ecommerce-product-details.html" class="text-dark">' + row.product.name + '</a></h5>' +
								'<p class="text-muted mb-0"> <span class="fw-medium">' + row.product.category + '</span></p>' +
								'</div>' +
								'</div>'),
				    	row.stock,
				    	gridjs.html(row.price+' '+langData.sar),
				    	gridjs.html(row.orders),
				    	gridjs.html('<span class="badge bg-light text-body fs-12 fw-medium"><i class="mdi mdi-star text-warning me-1"></i>' + row.rating + '</span></td>'),

				    	row.published_date,
				    	gridjs.html('<div class="dropdown">' +
								'<button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">' +
								'<i class="ri-more-fill"></i>' +
								'</button>' +
								'<ul class="dropdown-menu dropdown-menu-end">' +
								'<li><a class="dropdown-item" href="/vendor/products/'+row.id+'"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> '+langData.view+'</a></li>' +
								'<li><a class="dropdown-item edit-list" data-edit-id=' + row.id + ' href="/vendor/products/'+row.id+'/edit"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> '+langData.edit+'</a></li>' +
								'<li class="dropdown-divider"></li>' +
								'<li><a class="dropdown-item remove-list" href="#" data-id=' + row.id + ' data-bs-toggle="modal" onclick="showDeleteModal('+row.id+')" data-bs-target="#removeItemModal"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> '+langData.delete+'</a></li>' +
								'</ul>' +
								'</div>')
			    	]),
			    total: data => data.meta.last_page+1
			},
			search: {
			    server: {
			      url: (prev, keyword) => `${prev}&search=${keyword}&`
			    }
			 },
			pagination: {
			    limit: 10,
			    server: {
			      url: (prev, page, limit) => `${prev}&page=${page}&paginate=10&offset=${page * 10}`
			    }
			 },

			className: {
				th: 'text-muted',
			},
			style: {
			    th: {
			      'text-align': 'right'
			    },
			    td: {
			      'text-align': 'right'
			    }
			},
			language: {
			    'search': {
			      'placeholder': ' '//'🔍 '+langData.search_table
			    },
			    'pagination': {
				    'previous': 'السابق',
				    'next': 'القادم',
				    'showing': '😃 عرض',//+langData.displaying_table,
				    'of': 'من',//langData.pagination_of,
    				'to': 'إلي',//langData.pagination_to,
			      'results': () => langData.records
			    },
			    'loading': langData.table_loading,
			    'noRecordsFound': langData.no_records_found,
			    'error': langData.table_error,
			 },
			sort: true,
			enableRtl: true,
		}).render(table);
		// return productList;
}



// table select to remove
// checkbox-wrapper
var isSelected = 0;
function checkRemoveItem() {
	var tabEl = document.querySelectorAll('a[data-bs-toggle="tab"]');
	Array.from(tabEl).forEach(function (el) {
		el.addEventListener('show.bs.tab', function (event) {
			isSelected = 0;
			document.getElementById("selection-element").style.display = 'none';
		});
	});
	setTimeout(function () {
		Array.from(document.querySelectorAll(".checkbox-product-list input")).forEach(function (item) {
			item.addEventListener('click', function (event) {
				if (event.target.checked == true) {
					event.target.closest('tr').classList.add("gridjs-tr-selected");
				} else {
					event.target.closest('tr').classList.remove("gridjs-tr-selected");
				}

				var checkboxes = document.querySelectorAll('.checkbox-product-list input:checked');
				isSelected = checkboxes.length;

				if (event.target.closest('tr').classList.contains("gridjs-tr-selected")) {
					document.getElementById("select-content").innerHTML = isSelected;
					(isSelected > 0) ? document.getElementById("selection-element").style.display = 'block' : document.getElementById("selection-element").style.display = 'none';
				} else {

					document.getElementById("select-content").innerHTML = isSelected;
					(isSelected > 0) ? document.getElementById("selection-element").style.display = 'block' : document.getElementById("selection-element").style.display = 'none';
				}
			});
		});
		removeItems();
		removeSingleItem();
	}, 100);
}


// check to remove item
var checkboxes = document.querySelectorAll('.checkbox-wrapper-mail input');
function removeItems() {
	var removeItem = document.getElementById('removeItemModal');
	removeItem.addEventListener('show.bs.modal', function (event) {
		isSelected = 0;
		document.getElementById("delete-product").addEventListener("click", function () {
		var filtered = [];
			Array.from(document.querySelectorAll(".gridjs-table tr")).forEach(function (element,index) {
				if (element.classList.contains("gridjs-tr-selected")) {
					var getid = $('.form-check-input').val();
					// deleteProduct(getid);
				}
				if (element.querySelector('.form-check-input')) {
					if(element.querySelector('.form-check-input').checked){
						var getid = $('.form-check-input').val();
					console.log(getid)					
						deleteProduct(getid);
					}
				}
			});
			document.getElementById("btn-close").click();
			if (document.getElementById("selection-element"))
				document.getElementById("selection-element").style.display = 'none';

			checkboxes.checked = false;
		});
		
	})

}

function removeSingleItem(ele=null) {

	console.log(ele.attr('data-id'))
	deleteProduct(ele.attr('data-id'))

}

function deleteProduct(product_id)
{
	$.ajax({
	    url: '/vendor/products/'+product_id,
	    type: 'DELETE',
	    success: function(result) {
	    	console.log(result)
	    	productListAll.forceRender();
	        $('#removeItemModal').modal('toggle');
	    }
	});
}

function showDeleteModal(product_id)
{
	$('#delete-product').attr('data-id',product_id)
}

