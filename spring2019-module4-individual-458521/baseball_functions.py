#player class to hold at bats, hits, runs
class Player:
    def __init__(self,name,at_bats,hits,runs):
        self.name = name
        self.at_bats = at_bats
        self.hits = hits
        self.runs = runs

    def add_hits(self, new_hits):
        self.hits = self.hits + new_hits
        if(self.hits> self.at_bats):
            print("Warning: Batting average over 1\n")
            print("Hits: "+ self.hits)
            print("At bats: "+ self.at_bats)

    def add_runs(self, new_runs):
        self.runs = self.runs + new_runs
    def add_at_bats(self, new_at_bats):
        self.at_bats = self.at_bats + new_at_bats


#calculate batting average
    def get_batting_avg(self):
        if(self.hits> self.at_bats):
            print("Batting average over 1 for "+self.name+". Invalid batting average")
            return
        else:
            full_ans = self.hits/self.at_bats
            rounded_ans = format(round(full_ans,3),'.3f')
            return rounded_ans
