// const URL_WEB = window.location.href;
const detailContest = {
    loadContestDetail: function() {
        $(document).on('click', '.tabbar_detail_contest', function(e) {
            e.preventDefault();
            window.location.href = URL_ROUTE + '?page=detail'
        });
    },
    loadRounds: function() {
        $(document).on('click', '.tabbar_round_contest', function(e) {
            e.preventDefault();
            window.location.href = URL_ROUTE + '?page=rounds'
        });
    },
    loadTeams: function() {
        $(document).on('click', '.tabbar_teams_contest', function(e) {
            e.preventDefault();
            window.location.href = URL_ROUTE + '?page=teams'


        });
    },
    loadJudgess: function() {
        $(document).on('click', '.tabbar_judges_contest', function(e) {
            e.preventDefault();
            window.location.href = URL_ROUTE + '?page=judges'


        });
    },
}

detailContest.loadContestDetail()
detailContest.loadRounds()
detailContest.loadTeams()
detailContest.loadJudgess()