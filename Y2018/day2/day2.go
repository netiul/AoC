package main

import (
	"os"
	"bufio"
	"fmt"
	"strings"
)

func check(e error) {
	if e != nil {
		panic(e)
	}
}

func readIdsFromFile(fileName string) []string {
	file, err := os.Open(fileName)
	check(err)

	defer file.Close()

	var ids []string

	scanner := bufio.NewScanner(file)
	for scanner.Scan() {
		sequence := scanner.Text()

		ids = append(ids, sequence)
	}

	if err := scanner.Err(); err != nil {
		check(err)
	}

	return ids
}

func compareByCharacter(id string, c string) (bool, string) {
	var imbalances int
	matchingCharacters := []string{""}

	for i := 0; i < len(id); i++ {
		if id[i] != c[i] {
			imbalances = imbalances + 1
			if imbalances > 1 {
				return false, strings.Join(matchingCharacters, "")
			}
			continue
		}
		matchingCharacters = append(matchingCharacters, string(id[i]))
	}

	return imbalances == 1, strings.Join(matchingCharacters, "")
}

func compare(id string, ids []string) (string, bool) {
	var matches string

	for _, c := range ids {
		if found, matches := compareByCharacter(id, c); found == true {
			return matches, true
		}
	}

	return matches, false
}

func main()  {

	ids := readIdsFromFile("Y2018/day2/input.txt")

	var twoLetters int
	var threeLetters int

	for _, id := range ids {
		letterMap := make(map[string]int)

		for i := 0; i < len(id); i = i + 1 {
			letterMap[string(id[i])] = letterMap[string(id[i])] + 1
		}

		foundTwoLetters := false
		foundThreeLetters := false

		for _, count := range letterMap {
			if count == 2 && foundTwoLetters == false {
				foundTwoLetters = true
				twoLetters = twoLetters + 1
			}
			if count == 3 && foundThreeLetters == false {
				foundThreeLetters = true
				threeLetters = threeLetters + 1
			}
		}
	}

	checksum := twoLetters * threeLetters

	fmt.Printf("Found %d times a letter apearing twice and found %d times a letter appearing three times. Checksum %d * %d = %d\n", twoLetters, threeLetters, twoLetters, threeLetters, checksum)

	var match string

	for k, id := range ids {
		comparators := append(ids[:k], ids[k+1:]...)
		if matchingCharacters, found := compare(id, comparators); found == true {
			match = matchingCharacters
			break
		}
	}

	fmt.Printf("Matching characters between closest ids: %s", match)
}
