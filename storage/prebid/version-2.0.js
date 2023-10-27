//Versão 2.0
var pbjs = pbjs || {};
pbjs.que = pbjs.que || [];

var googletag = googletag || {};
googletag.cmd = googletag.cmd || [];

(function(window, document, pbjs, googletag) {
'use strict';
if (typeof(hbBeetAds) !== 'undefined') return;

var PREBID_TIMEOUT = 3000; // ms
var FAILSAFE_TIMEOUT = 5000; // ms
var REFRESH_ONRESIZE = false;
var DFP_PAGEURL = "";
var DFP_SRA = true;
var APS = false;
var APS_PUBID = "";


function detectmob() {
  if (sessionStorage.desktop) // desktop storage
       return false;
   else if (localStorage.mobile) // mobile storage
       return true;

   var mobile = ['iphone','ipad','android','blackberry','nokia','opera mini','windows mobile','windows phone','iemobile','tablet','mobi'];
   var ua=navigator.userAgent.toLowerCase();
   for (var i in mobile) if (ua.indexOf(mobile[i]) > -1) return true;

   return false;
}

if(detectmob()){
  var adUnits = [
      {adUnitChangeMobile}
  ];
}else{
  var adUnits = [
      {adUnitChangeDesktop}
  ];
}

var adConfig = {
    "priceGranularity": {
        "buckets": [
            {
                "min": 0.1,
                "max": 10,
                "increment": 0.01,
                "precision": 2
            }
        ]
    },
    "cache": {
        "url": false
    },
    "currency": {
        "adServerCurrency": "USD"
    },
    "userSync": {
        "filterSettings": {
            "iframe": {
                "bidders": "*",
                "filter": "include"
            }
        }
    }
};

var adBidders = [];

var blockAdsLoad = false;
if (blockAdsLoad && window.__cmp) {
	window.__cmp('getGooglePersonalization', function (consent, isSuccess) {
		if (!isSuccess) return;
		blockAdsLoad = false;
		if (!consent.googlePersonalizationData.consentValue) {
			googletag.cmd.push(function () {
				googletag.pubads().setRequestNonPersonalizedAds(1);
			});
		}
	});
}

var adMapping = [];

(function() {
	var pbs = document.createElement('script');
	pbs.type = 'text/javascript';
	pbs.async = true;
	pbs.src = 'https://beetadsscripts.nyc3.cdn.digitaloceanspaces.com/crm/script/pre.js';
	var target = document.getElementsByTagName('head')[0];
	target.insertBefore(pbs, target.firstChild);
})();


(function () {
	var gads = document.createElement('script');
	gads.async = true;
	gads.type = 'text/javascript';
	gads.src = 'https://www.googletagservices.com/tag/js/gpt.js';
	var target = document.getElementsByTagName('head')[0];
	target.insertBefore(gads, target.firstChild);
})();

function Fixed() {
  var _body = document.getElementsByTagName('body')[0];
  var div = document.createElement("div");
  div.style.position = "fixed";

  div.style.zIndex = "99999";
  if(detectmob()){
    div.style.width = "320px";
    div.id = "Position_Fixed";
    div.style.height = "50px";
  }else{
    div.style.width = "728px";
    div.style.height = "90px";
    div.id = "Position_TopFixed";
  }

  div.style.transform = "translateX(-50%)";
  div.style.bottom = "0px";
  div.style.left = "50%";
  _body.appendChild(div);
}

if (APS) {
	!function(a9,a,p,s,t,A,g){if(a[a9])return;function q(c,r){a[a9]._Q.push([c,r])}a[a9]={init:function(){q("i",arguments)},fetchBids:function(){q("f",arguments)},setDisplayBids:function(){},targetingKeys:function(){return[]},_Q:[]};A=p.createElement(s);A.async=!0;A.src=t;g=p.getElementsByTagName(s)[0];g.parentNode.insertBefore(A,g)}("apstag",window,document,"script","//c.amazon-adsystem.com/aax2/apstag.js");
}

(function () {
	if ('IntersectionObserver' in window &&
		'IntersectionObserverEntry' in window &&
		'intersectionRatio' in window.IntersectionObserverEntry.prototype) return;
	var plf = document.createElement('script');
	plf.type = 'text/javascript';
	plf.async = true;
	plf.src = 'https://beetadsscripts.nyc3.digitaloceanspaces.com/crm/script/polyfill.min.js';
	var target = document.getElementsByTagName('head')[0];
	target.insertBefore(plf, target.firstChild);
	window.hbm_polyfill = plf;
})();

{recaptchaScript}

function getCpm(bidCpm, bid, pubshare, floor) {
	var bidUSD = (typeof bid.getCpmInNewCurrency === "function") ? bid.getCpmInNewCurrency('USD') : bid.cpm;
	if(bidUSD * pubshare < floor){
		return 0;
	}
	return bidCpm * pubshare;
}

function getBidderCode(bidderCode) {
	if (adBidders && adBidders[bidderCode]) {
		bidderCode += ',' + adBidders[bidderCode];
	}
	return bidderCode;
}

pbjs.que.push(function() {
	pbjs.setConfig(adConfig);
	pbjs.bidderSettings = {

	};

  pbjs.addAdUnits(adUnits);

	pbjs.onEvent('auctionInit', function(data){
		for (var i in data.adUnitCodes) {
			var u = adUnits.filter(function(u) {
				return u.code === data.adUnitCodes[i];
			})[0];
			if (!u) return;
			if (!u.hbm_stats) u.hbm_stats = [];
			u.hbm_stats.push({
				event: 'auctionInit',
				v: 'v2',
				user_id: u.hbm_zone.userid,
				website_id: u.hbm_zone.websiteid,
				zone_id: u.hbm_zone.zoneid,
				refresh: u.hbm_zone.isRefresh ? 't' : '',
			});
		}
	});

	// pbjs.onEvent('auctionEnd', function(data){
	// 	for (var i in data.adUnitCodes) {
	// 		sendStatistics(data.adUnitCodes[i]);
	// 	}
	// });

	pbjs.onEvent('bidRequested', function(data){
		for (var i in data.bids) {
			var u = adUnits.filter(function(u) {
				return u.code === data.bids[i].adUnitCode;
			})[0];
			if (!u) return;
			if (!u.hbm_stats) u.hbm_stats = [];
			u.hbm_stats.push({
				event: 'bidRequested',
				v: 'v2',
				user_id: u.hbm_zone.userid,
				website_id: u.hbm_zone.websiteid,
				zone_id: u.hbm_zone.zoneid,
				bidderCode: getBidderCode(data.bids[i].bidder),
				refresh: u.hbm_zone.isRefresh ? 't' : '',
			});
		}
	});
	pbjs.onEvent('bidTimeout', function(data){
		for (var i in data) {
			var u = adUnits.filter(function(u) {
				return u.code === data[i].adUnitCode;
			})[0];
			if (!u) return;
			if (!u.hbm_stats) u.hbm_stats = [];
			u.hbm_stats.push({
				event: 'bidTimeout',
				v: 'v2',
				user_id: u.hbm_zone.userid,
				website_id: u.hbm_zone.websiteid,
				zone_id: u.hbm_zone.zoneid,
				bidderCode: getBidderCode(data[i].bidder),
				refresh: u.hbm_zone.isRefresh ? 't' : '',
			});
		}
	});
	pbjs.onEvent('bidResponse', function(data){
		var u = adUnits.filter(function(u) {
			return u.code === data.adUnitCode;
		})[0];
		if (!u) return;
		if (!u.hbm_stats) u.hbm_stats = [];
		u.hbm_stats.push({
			event: 'bidResponse',
			v: 'v2',
			user_id: u.hbm_zone.userid,
			website_id: u.hbm_zone.websiteid,
			zone_id: u.hbm_zone.zoneid,
			bidderCode: getBidderCode(data.bidder),
			timeToRespond: data.timeToRespond,
			width: data.width,
			height: data.height,
			cpm: (typeof data.getCpmInNewCurrency === "function") && data.cpm > 0 ? data.getCpmInNewCurrency('USD') : data.cpm,
			refresh: u.hbm_zone.isRefresh ? 't' : '',
		});
	});
	pbjs.onEvent('bidWon', function(data){
		var u = adUnits.filter(function(u) {
			return u.code === data.adUnitCode;
		})[0];
		if (!u) return;
		if (!u.hbm_stats) u.hbm_stats = [];
		u.hbm_stats.push({
			event: 'bidWon',
			v: 'v2',
			user_id: u.hbm_zone.userid,
			website_id: u.hbm_zone.websiteid,
			zone_id: u.hbm_zone.zoneid,
			bidderCode: getBidderCode(data.bidder),
			width: data.width,
			height: data.height,
			cpm: (typeof data.getCpmInNewCurrency === "function") && data.cpm > 0 ? data.getCpmInNewCurrency('USD') : data.cpm,
			refresh: u.hbm_zone.isRefresh ? 't' : '',
		});
	});

});

googletag.cmd.push(function() {
	googletag.pubads().disableInitialLoad();
	googletag.pubads().addEventListener('slotOnload', function(event) {
		adUnits.filter(function(u) {
			return u.hbm_zone.slot === event.slot;
		});
	});

	if (DFP_PAGEURL !== '')
		googletag.pubads().set('page_url',DFP_PAGEURL);
	googletag.pubads().collapseEmptyDivs();
	googletag.pubads().setCentering(true);
	if (DFP_SRA)
		googletag.pubads().enableSingleRequest();
	googletag.enableServices();
});

if (APS) {
	apstag.init({
		pubID: APS_PUBID,
		adServer: 'googletag',
	});
}

function sendAdserverRequest(u) {
	if (!u.hbm_zone.isForSend) return;
	if (u.hbm_zone.back < (1 + APS)) return;
	u.hbm_zone.isForSend = false;

	googletag.cmd.push(function() {
		pbjs.que.push(function() {
			pbjs.setTargetingForGPTAsync([u.code]);
			googletag.pubads().refresh([u.hbm_zone.slot]);
		});
	});
}

function startAuction(u) {
	if (blockAdsLoad) return;
	if (!u.hbm_zone.isVisible) return;

	if (!u.hbm_zone.counter || u.hbm_zone.isRefresh) {
		console.log("start auction "+u.code);
		u.hbm_zone.counter = u.hbm_zone.counter || 0;
		u.hbm_zone.counter ++;
		u.hbm_zone.isForSend = true;
		u.hbm_zone.back = 0;

		if (APS) {
			var apsSlots = [];
			apsSlots.push({
				slotID: u.code,
				slotName: u.hbm_zone.slot_code,
				sizes: u.hbm_zone.slot_sizes,
			});

			apstag.fetchBids({
				timeout: PREBID_TIMEOUT,
				slots: apsSlots,
			}, function(bids) {
				googletag.cmd.push(function() {
					apstag.setDisplayBids();
					u.hbm_zone.back += 1;
					sendAdserverRequest(u);
				});
			});
		}

		pbjs.que.push(function() {
			pbjs.requestBids({
				timeout: PREBID_TIMEOUT,
				adUnitCodes: [u.code],
				bidsBackHandler: function(){
					u.hbm_zone.back += 1;
					sendAdserverRequest(u);
				}
			});
		});

		setTimeout(function() {
			u.hbm_zone.back += (1 + APS);
			sendAdserverRequest(u);
		}, FAILSAFE_TIMEOUT);

		if (u.hbm_zone.refresh && (u.hbm_zone.counter <= u.hbm_zone.refresh_limit || !u.hbm_zone.refresh_limit)) {
			setTimeout(function() {
				u.hbm_zone.isRefresh = true;
				startAuction(u);
			}, u.hbm_zone.refresh);
		}
	}
}

if (window.hbm_polyfill) {
	window.hbm_polyfill.onload = function(){ Fixed(); onLoad(); setInterval(function() { onLoad(); }, 500); }
}
else {
	window.onload = function(){ Fixed(); onLoad(); setInterval(function() { onLoad(); }, 500); }
}


function HBBeetAds() {}

function onLoad() {
	if (blockAdsLoad) return;

	adUnits.filter(function(u) {
		return u.code && !u.hbm_zone.isExists;
	}).forEach(function(u) {
		var target = document.getElementById(u.code);
		if (target) {
			u.hbm_zone.isExists = true;

			googletag.cmd.push(function() {
				if (u.hbm_zone.outofpage)
					u.hbm_zone.slot = googletag.defineOutOfPageSlot(u.hbm_zone.slot_code, u.code);
				else
					u.hbm_zone.slot = googletag.defineSlot(u.hbm_zone.slot_code, u.hbm_zone.slot_sizes, u.code);
				if (adMapping[u.hbm_zone.zoneid])
					u.hbm_zone.slot.defineSizeMapping(adMapping[u.hbm_zone.zoneid]);
				u.hbm_zone.slot.addService(googletag.pubads());
				if (!target.innerHTML)
					googletag.display(u.code);
			});

			if (u.hbm_zone.lazy_loading && 'IntersectionObserver' in window) {
				target.outerHTML = "<div id='hbm-"+u.code+"'>" + target.outerHTML + "</div>";
				var target2 = document.getElementById('hbm-'+u.code);
				var observerLazyLoading = new IntersectionObserver(intersectionObserverLazyLoading, { root: null, rootMargin: "0px 0px "+u.hbm_zone.lazy_loading_offset+"px 0px", threshold: [0.0, 0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9, 1.0] });
				observerLazyLoading.observe(target2);
			}
			if (!u.hbm_zone.lazy_loading) {
				u.hbm_zone.isVisible = true;
				u.hbm_zone.isRefresh = false;
				startAuction(u);
			}
		}
	});
}

function intersectionObserverLazyLoading(entries, observer) {
	entries.forEach(function(entry) {
		var u = adUnits.filter(function(u) {
			return 'hbm-'+u.code === entry.target.id;
		})[0];
		if (u) {
			var v = u.hbm_zone.isVisible;
			u.hbm_zone.isVisible = entry.intersectionRatio > 0;
			if (u.hbm_zone.isVisible && !v) {
				if (!u.hbm_zone.counter) {
					u.hbm_zone.isRefresh = false;
					startAuction(u);
				}
				else if (u.hbm_zone.refresh && (u.hbm_zone.counter <= u.hbm_zone.refresh_limit || !u.hbm_zone.refresh_limit)) {
					u.hbm_zone.isRefresh = true;
					startAuction(u);
				}
			}
		}
	});
};

var resizeTimerId;
if (REFRESH_ONRESIZE) {
	window.addEventListener("resize", function() {
		clearTimeout(resizeTimerId);
		resizeTimerId = setTimeout(doneResizing, 1000);
	});
}

function doneResizing(){
	console.log("resized");
	adUnits.forEach(function(u) {
		u.hbm_zone.counter = 0;
		u.hbm_zone.isRefresh = false;
		startAuction(u);
	});
}


HBBeetAds.prototype.dynamic = function(divid, zoneid) {
	var u = adUnits.filter(function(u) {
		return u.hbm_zone.zoneid == zoneid;
	})[0];
	if (!u) return;
	u.code = divid;
}


HBBeetAds.prototype.refresh = function(zoneid) {
	var u = adUnits.filter(function(u) {
		return u.hbm_zone.zoneid == zoneid;
	})[0];
	if (!u) return;
	u.hbm_zone.counter = 0;
	u.hbm_zone.isRefresh = false;
	startAuction(u);
}

window.HBBeetAds = HBBeetAds;

}(window, document, pbjs, googletag));

var hbBeetAds = new HBBeetAds();

//Google Analytcs
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-136590289-2', 'auto');
ga('send', 'pageview');

{recapchaExec}
