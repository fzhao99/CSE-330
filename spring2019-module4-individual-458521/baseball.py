import sys, os,re

# print usage message for bad input
import sys, os

if len(sys.argv) < 2:
    sys.exit(f"Usage: {sys.argv[0]} filename")

filename = sys.argv[1]

if not os.path.exists(filename):
    sys.exit(f"Error: File '{sys.argv[1]}' not found")


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
            return 0
        elif(self.at_bats==0):
            return 0
        else:
            full_ans = self.hits/self.at_bats
            rounded_ans = format(round(full_ans,3),'.3f')
            return rounded_ans

players = {}
output = {}
name_regex = re.compile(r"([A-Z]{1})([a-z]+)(\s)([A-Z]{1})([a-z]+)")
non_word_regex = re.compile(r"[^\w\s]")
numbers_regex = re.compile(r"\d")

with open(filename) as f:
    #loop through each line, capture info
    for line in f:
        if non_word_regex.match(line):
            pass
        else:
            name = name_regex.match(line)
            numbers = numbers_regex.findall(line)
        #see if player name exists in dictionary
            if name == None:
                pass
            elif name.group(0) in players:
                #if so, update information
                players[name.group(0)].add_at_bats(int(numbers[0]))
                players[name.group(0)].add_hits(int(numbers[1]))
                players[name.group(0)].add_runs(int(numbers[2]))

            else:
                #if not, create a new player
                players[name.group(0)] = Player(name.group(0), int(numbers[0]),
                 int(numbers[1]),int(numbers[2]))

for player in players:
    cur_player = players[player]
    bat_avg = cur_player.get_batting_avg()
    output[cur_player.name] = bat_avg

sorted_output = sorted(output.items(), key=lambda kv:kv[1])


for entry in reversed(sorted_output):
    print(entry[0] + ": "+str(entry[1]))
