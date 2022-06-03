console.log('TV Series and Films API (JavaScript) Enabled');

const API_KEY = '9dfd01779b6fdeb1cde19f1c010bb6a9';

const SEARCH_TV_URL = `https://api.themoviedb.org/3/search/tv?api_key=${API_KEY}&query=`;
const TV_DETAILS_URL = `https://api.themoviedb.org/3/tv/`;

const stateObject = {
    data: [],
    searchData: []
};

const getTV = async (id) => {
    const response = await fetch(`${TV_DETAILS_URL}${id}?api_key=${API_KEY}&language=en-US`);
    const result = await response.json();
    return result;
};

const buildDataTable = async (dataArr) => {
    //TODO: Instruction to clear the Description Body
    console.log( dataArr );
};

const searchByQuery = async (query) => {
    if ( query ) {
        const response = await fetch(SEARCH_TV_URL + query);
        const { result } = await response.json();
        return result;
    }
};

function createNewInfoForTV ( seriesName ) {
    seriesName = getTVSeriesName( seriesName );
    const searchData = await searchByQuery( seriesName );
    if ( searchData ) {
        stateObject.searchData = searchData;
        await buildDataTable( searchData );
    } else {
        stateObject.searchData = [];
        await buildDataTable( stateObject.data );
    }
}

//const buildDataTable = async (dataArr) => {
//    tableBody.innerHTML = '';
//
//    for (let item of dataArr) {
//        const tv = await getTV(item.id);
//        if (filterData(tv)) {
//            const row = document.createElement('tr');
//
//            const titleCell = row.insertCell(0);
//            titleCell.innerHTML = tv.name;
//
//            const genreCell = row.insertCell(1);
//            genreCell.innerHTML =
//                tv.genres.length > 0 ? tv.genres[0].name : 'Unknown';
//
//            const languageCell = row.insertCell(2);
//            languageCell.innerHTML =
//                tv.spoken_languages.length > 0
//                    ? tv.spoken_languages[0].english_name
//                    : 'Unknown';
//
//            const ratingCell = row.insertCell(3);
//            ratingCell.innerHTML = tv.vote_average;
//
//            const eyeIconCell = row.insertCell(4);
//            eyeIconCell.innerHTML = `<i class="far fa-eye-slash" onclick="showDetails(this)"></i>`;
//
//            const detailsCell = row.insertCell(5);
//            detailsCell.classList.add('spanRow', 'hideDetail');
//            detailsCell.innerHTML = `<div id="rowDetail">
//                    <img src="${
//                                            tv.poster_path
//                                                ? IMAGE_URL + tv.poster_path
//                                                : '../img/no-image.png'
//                                        }" alt="" class="mediaImage" />
//                    <div id="columnDetail">
//                        <p><span class="subHeading">Overview:</span> ${
//                                                tv.overview
//                                            }</p>
//                    <p>
//                                            <span class="subHeading">Release Date:</span> ${tv.first_air_date}
//                                        </p>
//                    <p>
//                                            <span class="subHeading">Seasons:</span> ${tv.number_of_seasons}
//                                        </p>
//                    </div>
//                    </div>`;
//
//            tableBody.appendChild(row);
//        }
//    }
//};