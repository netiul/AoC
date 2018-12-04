package main

import (
	"fmt"
	//"io/ioutil"
	//"strconv"
	"os"
	"bufio"
	strconv "strconv"
)

func check(e error) {
	if e != nil {
		panic(e)
	}
}

func readNumbersFromFile(fileName string) []int {
	file, err := os.Open(fileName)
	check(err)

	defer file.Close()

	var numbers []int

	scanner := bufio.NewScanner(file)
	for scanner.Scan() {
		operator := string(scanner.Text()[0])
		number, err := strconv.Atoi(scanner.Text()[1:])
		check(err)

		switch operator {
		case "+":
			number = 0 + number
		case "-":
			number = 0 - number
		}

		numbers = append(numbers, number)
	}

	if err := scanner.Err(); err != nil {
		check(err)
	}

	return numbers
}

func hasFrequency(frequencies []int, frequency int) bool {
	for _, number := range frequencies {
		if number == frequency {
			return true
		}
	}
	return false
}

func main() {

	numbers := readNumbersFromFile("Y2018/day1/input.txt")

	var frequency int

	for _, number := range numbers {
		frequency = frequency + number
	}

	fmt.Printf("Sum of frequency changes is %d\n", frequency)

	var frequencies []int
	frequencies = append(frequencies, 0)

	var doubleFrequency int
	frequency = 0

iterate:
	for {
		for _, number := range numbers {
			frequency = frequency + number
			if hasFrequency(frequencies, frequency) {
				doubleFrequency = frequency
				break iterate
			}
			frequencies = append(frequencies, frequency)
		}
	}

	fmt.Printf("First reaches frequency %d twice\n", doubleFrequency)
}
